<?php
/*
 * File name: UserAPIController.php
 * Last modified: 2022.01.18 at 23:52:40
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\EProviderUser;
use App\Repositories\CustomFieldRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserRepository;
use App\Traits\SendSms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Repositories\EProviderRepository;

class UserAPIController extends Controller
{
    use SendSms;

    private $userRepository;
    private $uploadRepository;
    private $roleRepository;
    private $customFieldRepository;
    /** @var  EProviderRepository */
    private $eProviderRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EProviderRepository $eProviderRepo, UserRepository $userRepository, UploadRepository $uploadRepository, RoleRepository $roleRepository, CustomFieldRepository $customFieldRepo)
    {
        $this->userRepository = $userRepository;
        $this->uploadRepository = $uploadRepository;
        $this->roleRepository = $roleRepository;
        $this->customFieldRepository = $customFieldRepo;
        $this->eProviderRepository = $eProviderRepo;
    }

    function login(Request $request)
    {
        try {
            $this->validate($request, [
                'phone_number' => 'required',
                'password' => 'required',
            ]);
            if (auth()->attempt(['phone_number' => $request->input('phone_number'), 'password' => $request->input('password')])) {
                // Authentication passed...
                $user = auth()->user();
                $user->device_token = $request->input('device_token', '');
                $user->save();
                $user['provider'] = $user->hasRole('provider');

                return $this->sendResponse($user, 'User retrieved successfully');
            } else {
                return $this->sendError(__('auth.failed'), 200);
            }
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return
     */
    function register(Request $request)
    {
        try {
            $this->validate($request, User::$rules);
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            $user->phone_verified_at = $request->input('phone_verified_at');
            $user->device_token = $request->input('device_token', '');
            $user->password = Hash::make($request->input('password'));
            $user->api_token = Str::random(60);
            $user->save();

            $defaultRoles = $this->roleRepository->findByField('default', '1');
            $defaultRoles = $defaultRoles->pluck('name')->toArray();
            $user->assignRole($defaultRoles);

            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->userRepository->model());

            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $user->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }


        return $this->sendResponse($user, 'User retrieved successfully');
    }

    function logout(Request $request)
    {
        $user = $this->userRepository->findByField('api_token', $request->input('api_token'))->first();
        if (!$user) {
            return $this->sendError('User not found', 200);
        }
        try {
            auth()->logout();
        } catch (Exception $e) {
            $this->sendError($e->getMessage(), 200);
        }
        return $this->sendResponse($user['name'], 'User logout successfully');
    }

    function user(Request $request)
    {
        $user = $this->userRepository->findByField('api_token', $request->input('api_token'))->first();

        if (!$user) {
            return $this->sendError('User not found', 200);
        }

        return $this->sendResponse($user, 'User retrieved successfully');
    }

    function settings(Request $request)
    {
        $settings = setting()->all();
        $settings = array_intersect_key(
            $settings,
            [
                'default_tax' => '',
                'default_currency' => '',
                'default_currency_decimal_digits' => '',
                'app_name' => '',
                'currency_right' => '',
                'enable_paypal' => '',
                'enable_stripe' => '',
                'enable_razorpay' => '',
                'main_color' => '',
                'main_dark_color' => '',
                'second_color' => '',
                'second_dark_color' => '',
                'accent_color' => '',
                'accent_dark_color' => '',
                'scaffold_dark_color' => '',
                'scaffold_color' => '',
                'google_maps_key' => '',
                'fcm_key' => '',
                'mobile_language' => '',
                'app_version' => '',
                'enable_version' => '',
                'distance_unit' => '',
                'default_theme' => '',
                'app_short_description' => '',
                'default_country_code' => ''
            ]
        );
        if (!$settings) {
            return $this->sendError('Settings not found', 200);
        }
        $upload = $this->uploadRepository->findByField('uuid', setting('app_logo', ''))->first();
        $settings['app_logo'] = asset('images/logo_default.png');
        if ($upload && $upload->hasMedia('app_logo')) {
            $settings['app_logo'] = $upload->getFirstMediaUrl('app_logo');
        }

        return $this->sendResponse($settings, 'Settings retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param Request $request
     *
     */
    public function updatePassword(int $id, Request $request)
    {
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);
        
        if (Hash::check($request->old_password, $user->password) && $request->password == $request->confirm_password) { 
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            return $this->sendResponse(true, 'Password updated successfully');
        } else {
            return $this->sendError("Either old password is woring or confirm password didn't matched", 200);
        }
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            return $this->sendError('User not found');
        }
        $input = $request->except(['api_token']);
        try {
            if ($request->has('device_token')) {
                $user = $this->userRepository->update($request->only('device_token'), $id);
            } else {
                $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->userRepository->model());
                if (isset($input['password']) && $input['password']) {
                    $input['password'] = Hash::make($request->input('password'));
                }
                $eProvider = "";
                if(auth()->user()->hasRole('provider')){
                    $provider_id = EProviderUser::where('user_id', $id)->value('e_provider_id');
                    $input_provider = [];
                    $input_provider['name'] = $input['name'];
                    if (isset($input['phone_number'])) {
                        // $input_provider['mobile_number'] = $input['phone_number'];
                    }
                    if (isset($input['permanent_address'])) {
                        $input_provider['permanent_address'] = $input['permanent_address'];
                    }
    
                    $eProvider = $this->eProviderRepository->update($input_provider, $provider_id);
                }

                if (isset($input['avatar']) && $input['avatar']) {
                    $cacheUpload = $this->uploadRepository->getByUuid($input['avatar']);
                    $mediaItem = $cacheUpload->getMedia('avatar')->first();
                    if ($user->hasMedia('avatar')) {
                        $user->getFirstMedia('avatar')->delete();
                    }
                    if ($eProvider && $eProvider->hasMedia('image')) {
                        $eProvider->getFirstMedia('image')->delete();
                        $mediaItem->copy($eProvider, 'image');
                    }
                    $mediaItem->copy($user, 'avatar');
                }
                $exist_user = User::where('phone_number', $input['phone_number'])
                    ->where("id", "!=", $id)
                    ->count();
                if ($exist_user) {
                    return $this->sendError("User with this ". $input['phone_number'] ." already exists.", 200);
                }
                $user = $this->userRepository->update($input, $id);
                $userData = $user->toArray();
                $userData['provider'] = $user->hasRole('provider');
                if (isset($userData['custom_fields']['address']['value'])) {
                    $userData['user_address'] = $userData['custom_fields']['address']['value'];
                    $userData['address'] = $userData['custom_fields']['address']['value'];
                }
                if (isset($userData['custom_fields']['bio']['value'])) {
                    $userData['user_bio'] = $userData['custom_fields']['bio']['value'];
                    $userData['bio'] = $userData['custom_fields']['bio']['value'];
                }
                foreach (getCustomFieldsValues($customFields, $request) as $value) {
                    $user->customFieldsValues()
                        ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
                }
                unset($userData['custom_fields']);
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }

        return $this->sendResponse($userData, __('lang.updated_successfully', ['operator' => __('lang.user')]));
    }

    function sendResetLinkEmail(Request $request): JsonResponse
    {
        try {
            $this->validate($request, ['email' => 'required|email|exists:users']);
            $response = Password::broker()->sendResetLink(
                $request->only('email')
            );
            if ($response == Password::RESET_LINK_SENT) {
                return $this->sendResponse(true, 'Reset link was sent successfully');
            } else {
                return $this->sendError('Reset link not sent');
            }
        } catch (ValidationException $e) {
            return $this->sendError($e->getMessage());
        } catch (Exception $e) {
            return $this->sendError("Email not configured in your admin panel settings");
        }
    }

    function getOtp(Request $request)
    {
        $this->validate(
            $request,
            [
                'phone_number' => 'required',
            ],
            [
                'phone_number.required' => 'Phone number is required...',
            ]
        );

        $phone_number = $request->phone_number;

        $chars = "0123456789";
        $otpval = "";
        for ($i = 0; $i < 4; $i++) {
            $otpval .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        $otpmsg = $this->otpmsg($otpval, $phone_number);
        $responseData = json_decode($otpmsg['response'],true);

        if (isset($responseData['request_id'])) {
            return ['status' => true, 'message' => 'Verify OTP', 'data' => [$otpval]];
        } else {
            return ['status' => false, 'message' => 'Something went wrong or invalid number', 'data' => []];
        }
    }

    /**
     * Varify OTP callback.
     */
    public function verifyOtp(Request $request)
    {
        $phone_number = $request->phone_number;
        $otp = $request->otp;

        // check for otp verify
        $user = User::where('phone_number', "+91" . $phone_number)->where('otp_value', $otp)->first();

        if ($user) {
            $getotp = $user->otp_value;

            if ($otp == $getotp) {
                $user->otp_value = '';
                $user->save();
                return ['status' => true, 'message' => "Otp Matched Successfully", "data" => $user];
            } else {
                return ['status' => false, 'message' => "Wrong OTP"];
            }
        } else {
            return ['status' => false, 'message' => "User not registered"];
        }
    }
}

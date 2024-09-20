<?php
/*
 * File name: UserAPIController.php
 * Last modified: 2022.01.18 at 23:52:40
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API\EProvider;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\CustomFieldRepository;
use App\Events\EProviderChangedEvent;
use App\Models\EProviderType;
use App\Models\EProviderUser;
use App\Repositories\RoleRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Repositories\EProviderRepository;
use Illuminate\Support\Facades\Log;

class UserAPIController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /** @var  EProviderRepository */
    private $eProviderRepository;
    private $uploadRepository;
    private $roleRepository;
    private $customFieldRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, EProviderRepository $eProviderRepo, UploadRepository $uploadRepository, RoleRepository $roleRepository, CustomFieldRepository $customFieldRepo)
    {
        $this->userRepository = $userRepository;
        $this->uploadRepository = $uploadRepository;
        $this->eProviderRepository = $eProviderRepo;
        $this->roleRepository = $roleRepository;
        $this->customFieldRepository = $customFieldRepo;
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
                if (!$user->hasRole('provider')) {
                    return $this->sendError(__('auth.account_not_accepted'), 200);
                }
                $user->device_token = $request->input('device_token', '');
                // ============= getting the provider id associated with user
                $provider_id = EProviderUser::where('user_id', $user->id)->value('e_provider_id');

                // =======getting the provider info
                $provider = $this->eProviderRepository->with('eProviderType')->find($provider_id);
                $providerData = $provider->toArray();

                // =======unset the provider data
                unset($providerData['id']);
                unset($providerData['name']);
                unset($providerData['phone_number']);
                unset($providerData['mobile_number']);
                unset($providerData['address_proof']);
                unset($providerData['id_proof']);
                unset($providerData['custom_fields']);

                $userData = $user->toArray();
                if (isset($userData['custom_fields']['address']['value'])) {
                    $userData['user_address'] = $userData['custom_fields']['address']['value'];
                }
                if (isset($userData['custom_fields']['bio']['value'])) {
                    $userData['user_bio'] = $userData['custom_fields']['bio']['value'];
                }
                unset($userData['custom_fields']);
                $media = $user->getFirstMedia('avatar');
                $userData['avatar'] = "";
                if ($media && $media->url) {
                    $userData['avatar'] = $media->url;
                }
                // =======merging the provider and user data to array_user.
                $array_user = array_merge($userData, $providerData);

                return $this->sendResponse($array_user, 'User retrieved successfully');
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
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }

        return $this->sendResponse($user, 'User retrieved successfully');
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return
     */
    function providerRegister(Request $request)
    {
        // Log::emergency("<pre>" . print_r($request->all(), 1) . "</pre>");

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
            $provider = array_replace($defaultRoles, [0 => "provider"]);
            $user->assignRole($provider);


            $input = [
                "name" => $user->name,
                "e_provider_type_id" => "3",
                "users" => [
                    0 => $user->id,
                ],
                "description" => "",
                "files" => null,
                "phone_number" =>  $request->input('phone_number'),
                "mobile_number" =>  $request->input('phone_number'),
                "taxes" => [0 => 1],
                "availability_range" => "2",
                "available" => "1",
                "featured" => "1",
                "dob" => $request->dob,
                'aadhaar_no' => $request->aadhaar_number,
                'gender' => $request->gender,
                'permanent_address' => $request->permanenet_address,
                'education' => $request->education,
                'certification' => $request->certification,
                'services' => $request->services,
                'work_address' => $request->work_address,
                'pincode' => $request->pincode,
                'years_of_experience' => $request->experience,
            ];

            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());

            $eProvider = $this->eProviderRepository->create($input);
            $eProvider->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image'] && is_array($input['image']) && $input['image'] != null) {
                foreach ($input['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadRepository->getByUuid($fileUuid);
                    $mediaItem = $cacheUpload->getMedia('image')->first();
                    $mediaItem->copy($eProvider, 'image');
                }
            }

            // use dropzone to uploads kycs.
            if (isset($input['id_proof']) && $input['id_proof']) {
                if ($input['id_proof'] != null) {
                    $cacheUpload = $this->uploadRepository->getByUuid($input['id_proof']);
                    $mediaItem = $cacheUpload->getMedia('id_proof')->first();
                    if ($mediaItem != null) {
                        $mediaItem->copy($eProvider, 'id_proof');
                    }
                }
            }
            if (isset($input['address_proof']) && $input['address_proof']) {
                if ($input['address_proof'] != null) {
                    $cacheUpload = $this->uploadRepository->getByUuid($input['address_proof']);
                    $mediaItem = $cacheUpload->getMedia('address_proof')->first();
                    if ($mediaItem != null) {
                        $mediaItem->copy($eProvider, 'address_proof');
                    }
                }
            }
            event(new EProviderChangedEvent($eProvider, $eProvider));
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }

        $user->provider_id = $eProvider->id;

        return $this->sendResponse($user, 'User retrieved successfully');
    }

    public function providerFullRegister(Request $request, $id)
    {
        // getting provider id from user id.
        $provider_id = EProviderUser::where('user_id', $id)->value('e_provider_id');

        $input = [
            "description" => $request->description,
            "files" => null,
            "taxes" => [0 => 1],
            "availability_range" => $request->availability_range,
            "available" => "1",
            "featured" => "1",
            "experience" => $request->experience,
            "dob" => $request->dob,
            'aadhaar_no' => $request->aadhaar_no,
            'gender' => $request->gender,
            'permanent_address' => $request->permanent_address,
            'education' => $request->education,
            'certification' => $request->certification,
            'services' => $request->services,
            'pincode' => $request->pincode,
            'years_of_experience' => $request->years_of_experience,
            'city' => $request->city,
            'state' => $request->state,
        ];
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());
        $eProvider = $this->eProviderRepository->update($input, $provider_id);

        // use dropzone to uploads kycs.
        $input = $request->all();
        if (isset($input['id_proof']) && $input['id_proof']) {
            if ($input['id_proof'] != null) {

                // remove previus document of id proof
                if ($eProvider->hasMedia('id_proof')) {
                    $eProvider->getFirstMedia('id_proof')->delete();
                }

                if (is_array($input['id_proof'])) {

                    foreach ($input['id_proof'] as $fileUuid) {
                        if ($fileUuid['id'] != null) {
                            $cacheUpload = $this->uploadRepository->getByUuid($fileUuid['id']);
                            $mediaItem = $cacheUpload->getMedia('id_proof')->first();
                            if ($mediaItem != null) {
                                $mediaItem->copy($eProvider, 'id_proof');
                            }
                        }
                    }

                } else {
                    $cacheUpload = $this->uploadRepository->getByUuid($input['id_proof']);
                    
                    $mediaItem = $cacheUpload->getMedia('id_proof')->first();
                    
                    if(!is_null($mediaItem)){
                    
                        $mediaItem->copy($eProvider, 'id_proof');
                    
                    }
                }
            }
        }
        if (isset($input['address_proof']) && $input['address_proof']) {
            if ($input['address_proof'] != null) {

                // remove previus document of address proof
                if ($eProvider->hasMedia('address_proof')) {
                    $eProvider->getFirstMedia('address_proof')->delete();
                }

                if (is_array($input['address_proof'])) {
                  
                    foreach ($input['address_proof'] as $fileUuid) {
                  
                        if ($fileUuid['id'] != null) {
                  
                            $cacheUpload = $this->uploadRepository->getByUuid($fileUuid['id']);
                  
                            $mediaItem = $cacheUpload->getMedia('address_proof')->first();
                  
                            if ($mediaItem != null) {
                  
                                $mediaItem->copy($eProvider, 'address_proof');
                  
                            }
                        }
                    }
                } else {
                   
                    $cacheUpload = $this->uploadRepository->getByUuid($input['address_proof']);
                   
                    $mediaItem = $cacheUpload->getMedia('address_proof')->first();
                   
                    if(!is_null($mediaItem)){
                   
                        $mediaItem->copy($eProvider, 'address_proof');
                   
                    }
                }
            }
        }
        return $this->sendResponse($eProvider, 'Provider retrieved successfully');
    }


    function serviceType()
    {
        $providerType = \App\Models\EProviderType::all();
        return $providerType;
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
                'provider_app_name' => '',
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
                'default_country_code' => '',
                'enable_otp' => true,
            ]
        );

        if (!$settings) {
            return $this->sendError('Settings not found', 200);
        }

        return $this->sendResponse($settings, 'Settings retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     */
    public function update(int $id, UpdateUserRequest $request): JsonResponse
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
                if (isset($input['password'])) {
                    $input['password'] = Hash::make($request->input('password'));
                }
                if (isset($input['avatar']) && $input['avatar']) {
                    $cacheUpload = $this->uploadRepository->getByUuid($input['avatar']);
                    $mediaItem = $cacheUpload->getMedia('avatar')->first();
                    if ($user->hasMedia('avatar')) {
                        $user->getFirstMedia('avatar')->delete();
                    }
                    $mediaItem->copy($user, 'avatar');
                }
                $user = $this->userRepository->update($input, $id);

                foreach (getCustomFieldsValues($customFields, $request) as $value) {
                    $user->customFieldsValues()
                        ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
                }
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }

        return $this->sendResponse($user, __('lang.updated_successfully', ['operator' => __('lang.user')]));
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
}

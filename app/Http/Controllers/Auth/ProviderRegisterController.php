<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\RoleRepository;
use App\Events\EProviderChangedEvent;
use App\Models\EProviderType;
use App\Models\EService;
use App\Models\ProviderService;
use Illuminate\Validation\ValidationException;
use App\Repositories\UserRepository;
use App\Repositories\EProviderRepository;
use App\Repositories\UploadRepository;
use App\Repositories\CustomFieldRepository;
use Carbon\Carbon;

class ProviderRegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
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
        $this->eProviderRepository = $eProviderRepo;
        $this->uploadRepository = $uploadRepository;
        $this->roleRepository = $roleRepository;
        $this->customFieldRepository = $customFieldRepo;
    }
    public function register()
    {
        return view('auth.provider_register');
    }

    public function register_store(Request $request)
    {
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
            "featured" => "1"
        ];
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());

        $eProvider = $this->eProviderRepository->create($input);
        // dd();
        $eProvider->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
        if (isset($input['image']) && $input['image'] && is_array($input['image']) && $input['image'] != null) {
            foreach ($input['image'] as $fileUuid) {
                $cacheUpload = $this->uploadRepository->getByUuid($fileUuid);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($eProvider, 'image');
            }
        }
        event(new EProviderChangedEvent($eProvider, $eProvider));
        return redirect('/provier-full-registration' . "/" . $eProvider->id);
    }

    public function provider_full_registratoin()
    {
        $providerTypes = \App\Models\EProviderType::all();

        $services = EService::all();

        return view('auth.provider_full_registration', compact('providerTypes', 'services'));
    }

    public function provider_full_registratoin_store(Request $request, $id)
    {
        // dd($request->services);
        if ($request->hasFile('id_proof')) {
            $path = $request->file('id_proof')->store('uploads/id_proof');
            $input['id_proof'] = $path;
        }

        if ($request->hasFile('address_proof')) {
            $path = $request->file('address_proof')->store('uploads/address_proof');
            $input['address_proof'] = $path;
        }

        $input = [
            "description" => $request->description,
            "files" => null,
            "taxes" => [0 => 1],
            "availability_range" => $request->availability,
            "available" => "1",
            "featured" => "1",
            "experience" => $request->experience,
            "dob" => $request->dob,
            'aadhaar_no' => $request->aadhaar_number,
            'gender' => $request->gender,
            'permanent_address' => $request->permanent_address,
            'education' => $request->education,
            'certification' => $request->certification,
            'work_address' => $request->work_address,
            'pincode' => $request->pincode,
            'years_of_experience' => $request->year_of_experience,
        ];

        if ($request->hasFile('id_proof')) {
            $id_proof = 'id_proof_' . time() . '.' . request()->id_proof->getClientOriginalExtension();
            $request->id_proof->move(public_path('uploads/docs'), $id_proof);
            $input['id_proof'] = $id_proof;
        }

        if ($request->hasFile('address_proof')) {
            $address_proof = 'address_proof_' . time() . '.' . request()->address_proof->getClientOriginalExtension();
            $request->address_proof->move(public_path('uploads/docs'), $address_proof);
            $input['address_proof'] = $address_proof;
        }

        foreach ($request->services as $service_id) {
            $provider = new ProviderService();
            $provider->provider_id = $id;
            $provider->service_id = $service_id;
            $provider->save();
        }
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderRepository->model());

        $eProvider = $this->eProviderRepository->update($input, $id);
        return redirect()->route('users.profile');
    }
}

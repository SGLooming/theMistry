<?php
/*
 * File name: EServiceAPIController.php
 * Last modified: 2022.04.02 at 06:27:45
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API;


use App\Criteria\EServices\EServicesOfUserCriteria;
use App\Criteria\EServices\NearCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEServiceRequest;
use App\Http\Requests\UpdateEServiceRequest;
use App\Models\Advertisement;
use App\Models\AdvertisementService;
use App\Repositories\EServiceRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Nwidart\Modules\Facades\Module;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Models\EServiceCategory;
use App\Models\EProvider;
use App\Models\ProviderService;
use App\Models\EProviderUser;
use App\Repositories\EProviderRepository;

/**
 * Class EServiceController
 * @package App\Http\Controllers\API
 */
class EServiceAPIController extends Controller
{
    /** @var  eServiceRepository */
    private $eServiceRepository;
    /** @var UserRepository */
    private $userRepository;
    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    /** @var  EProviderRepository */
    private $eProviderRepository;


    public function __construct(EProviderRepository $eProviderRepo, EServiceRepository $eServiceRepo, UserRepository $userRepository, UploadRepository $uploadRepository)
    {
        $this->middleware('auth:api', ['only' => ['destroy']]);
        parent::__construct();
        $this->eServiceRepository = $eServiceRepo;
        $this->userRepository = $userRepository;
        $this->eProviderRepository = $eProviderRepo;
        $this->uploadRepository = $uploadRepository;
    }

    /**
     * Display a listing of the EService.
     * GET|HEAD /eServices
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $provider_id = EProviderUser::where('user_id', auth()->id())->value('e_provider_id');
        try {
            $this->eServiceRepository->pushCriteria(new RequestCriteria($request));
            $this->eServiceRepository->pushCriteria(new EServicesOfUserCriteria($provider_id));
            $this->eServiceRepository->pushCriteria(new NearCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $eServices = $this->eServiceRepository->all();

        $this->availableEServices($eServices);
        $this->availableEProvider($request, $eServices);
        $this->hasValidSubscription($request, $eServices);
        $this->orderByRating($request, $eServices);
        $this->limitOffset($request, $eServices);
        $this->filterCollection($request, $eServices);
        $eServices = array_values($eServices->toArray());
        return $this->sendResponse($eServices, 'E Services retrieved successfully');
    }

    /**
     * @param Collection $eServices
     */
    private function availableEServices(Collection &$eServices)
    {
        $eServices = $eServices->where('available', true);
    }

    /**
     * @param Request $request
     * @param Collection $eServices
     */
    private function availableEProvider(Request $request, Collection &$eServices)
    {
        if ($request->has('available_e_provider')) {
            $eServices = $eServices->filter(function ($element) {
                if (isset($element->eProvider->available)) {
                    return $element->eProvider->available;
                }
                return [];
            });
        }
    }

    /**
     * @param Request $request
     * @param Collection $eServices
     */
    private function hasValidSubscription(Request $request, Collection &$eServices)
    {
        if (Module::isActivated('Subscription')) {
            $eServices = $eServices->filter(function ($element) {
                return $element->eProvider->hasValidSubscription && $element->eProvider->accepted;
            });
        } else {
            return $eServices;
        }
    }

    /**
     * @param Request $request
     * @param Collection $eServices
     */
    private function orderByRating(Request $request, Collection &$eServices)
    {
        if ($request->has('rating')) {
            $eServices = $eServices->sortBy('rate', SORT_REGULAR, true);
        }
    }

    /**
     * Display the specified EService.
     * GET|HEAD /eServices/{id}
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        try {
            $this->eServiceRepository->pushCriteria(new RequestCriteria($request));
            $this->eServiceRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $eService = $this->eServiceRepository->findWithoutFail($id);
        $provider_ids = ProviderService::where('service_id', $id)->pluck('provider_id');
        $data['providers'] = [];
        if (!empty($provider_ids)) {
            $eService->providers = EProvider::whereIn('id', $provider_ids)->where('accepted', true)->where('available', true)->orderBy('tm_certified', 'desc')->latest()->get();
        }
        if (empty($eService)) {
            return $this->sendError('EService not found');
        }
        if ($request->has('api_token')) {
            $user = $this->userRepository->findByField('api_token', $request->input('api_token'))->first();
            if (!empty($user)) {
                auth()->login($user, true);
            }
        }
        $this->filterModel($request, $eService);

        $response = $eService->toArray();

        $ad_ids = AdvertisementService::where('service_id', $response['id'])->pluck('ad_id')->toArray();

        if (!empty($ad_ids)) {

            unset($response['media']);

            // fetching all the advertisements from ads id
            $advertisement = Advertisement::whereIn('id', $ad_ids)->where('featured', true)->get();

            $response['media'] = $advertisement;
        }

        return $this->sendResponse($response, 'EService retrieved successfully');
    }

    /**
     * Store a newly created EService in storage.
     *
     * @param CreateEServiceRequest $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        
        try {
            $input = $request->all();

            // check if the description is filled then update.
            if (isset($input['description']) && $input['description'] != '') {
                $eProvider = $this->eProviderRepository->update($input, $request->e_provider_id);
            }else{
                $eProvider = [];
            }

            // store services 
            if (isset($request->services)) {
                if (is_array($request->services)) {
                    foreach ($request->services as $service_id) {

                        // if the services already exists then service will not store again.
                        if (!ProviderService::where('service_id', $service_id)->where('provider_id', $request->e_provider_id)->exists()) {

                            $provider = new ProviderService();

                            $provider->provider_id = $request->e_provider_id;

                            $provider->service_id = $service_id;

                            $provider->save();
                        }
                    }
                } else if (isset($input['services'])) {
                    if (isset($input['user_id'])) {

                        $provider_id = EProviderUser::where('user_id', $input['user_id'])->value('e_provider_id');

                        // if the services already exists then service will not store again.
                        if (!ProviderService::where('service_id', $input['services'])->where('provider_id', $provider_id)->exists()) {

                            $provider = new ProviderService();

                            $provider->provider_id = $provider_id;

                            $provider->service_id = $input['services'];

                            $provider->save();
                        }
                    }
                }
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse($eProvider, __('lang.saved_successfully', ['operator' => __('lang.e_service')]));
    }

    /**
     * Update the specified EService in storage.
     *
     * @param int $id
     * @param UpdateEServiceRequest $request
     *
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function update(int $id, Request $request)
    {
        $provider_services = ProviderService::where('provider_id', $request->e_provider_id)->where('service_id', $id);

        $response = [];

        if ($provider_services) {

            $provider_services->delete();
        }
        try {
            if (isset($request->services)) {

                foreach ($request->services as $service_id) {

                    if (!ProviderService::where('service_id', $service_id)->where('provider_id', $request->e_provider_id)->exists()) {

                        $provider = new ProviderService();

                        $provider->provider_id = $request->e_provider_id;

                        $provider->service_id = $service_id;

                        $provider->save();
                        $response = $provider;
                    }
                }
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse($response, __('lang.updated_successfully', ['operator' => __('lang.e_service')]));
    }

    /**
     * Remove the specified EService from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->eServiceRepository->pushCriteria(new EServicesOfUserCriteria(auth()->id()));

        $provider_id = EProviderUser::where('user_id', auth()->id())->value('e_provider_id');

        $provider_service = ProviderService::where('service_id', $id)->where('provider_id', $provider_id);

        if (empty($provider_service)) {
            return $this->sendError('EService not found');
        }

        $provider_service->delete();

        return $this->sendResponse($provider_service->tosql(), __('lang.deleted_successfully', ['operator' => __('lang.e_service')]));
    }

    /**
     * Remove Media of EService
     * @param Request $request
     * @throws RepositoryException
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        try {
            $this->eServiceRepository->pushCriteria(new EServicesOfUserCriteria(auth()->id()));
            $eService = $this->eServiceRepository->findWithoutFail($input['id']);
            if ($eService->hasMedia($input['collection'])) {
                $eService->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function getServicesByCategory($category_id)
    {
        $service_ids = EServiceCategory::where('category_id', $category_id)->pluck('e_service_id', 'e_service_id');
        $eServices = $this->eServiceRepository->whereIn('id', $service_ids)->get();
        $response = [];
        foreach ($eServices as $key => $value) {
            $response[] = [
                'id' => $value->id,
                'name' => $value->name,
            ];
        }
        return $this->sendResponse($response, 'E Services retrieved successfully');
    }
}

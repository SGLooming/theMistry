<?php
/*
 * File name: EServiceAPIController.php
 * Last modified: 2022.04.02 at 06:27:45
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\EServiceProviderReview;
use DB;

/**
 * Class EServiceController
 * @package App\Http\Controllers\API
 */
class EServiceProviderReviewAPIController extends Controller
{
   
    /**
     * Store a newly created EService in storage.
     *
     * @param CreateEServiceRequest $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        
        $service_provider_review = new EServiceProviderReview();
        $service_provider_review->e_provider_id = $request->e_provider_id;
        $service_provider_review->e_service_id = $request->e_service_id;
        $service_provider_review->user_id = $request->user_id;
        $service_provider_review->rate = $request->rate;
        $service_provider_review->review = $request->review;

        $service_provider_review->save();

        return $this->sendResponse($service_provider_review, __('lang.saved_successfully', ['operator' => __('lang.e_service')]));
    }

    public function show(int $id): JsonResponse
    {
        $reviews = EServiceProviderReview::select('e_provider_id', DB::raw('AVG(rate) as rate'))
            ->groupBy('e_provider_id')
            ->get();
        return $this->sendResponse($reviews->toArray(), __('lang.saved_successfully', ['operator' => __('lang.e_service')]));
        
    }

}

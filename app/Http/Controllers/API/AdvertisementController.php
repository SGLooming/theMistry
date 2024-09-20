<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementService;
use Illuminate\Http\JsonResponse;

class AdvertisementController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($service_id): JsonResponse
    {
        // fetching all the advertisement ids as array.
        $advertisement_ids = AdvertisementService::where('service_id', $service_id)->pluck('ad_id');

        // fetching all the advertisements from ads id
        $advertisement = Advertisement::whereIn('id', $advertisement_ids)->where('featured', true)->get();

        // throw ads not found message if the advertisement not found
        if (empty($advertisement)) {

            return $this->sendError('Ads Not Found.');
        }

        return $this->sendResponse($advertisement->toArray(), 'Advertisement retrieved successfully');
    }
}

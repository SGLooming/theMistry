<?php
/*
 * File name: EProviderReviewAPIController.php
 * Last modified: 2021.02.22 at 10:53:38
 * Copyright (c) 2021
 */

namespace App\Http\Controllers\API;


use App\Criteria\EServiceReviews\EServiceReviewsOfUserCriteria;
use App\Criteria\EProviderReviews\EProviderReviewsOfUserCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\EProviderReviewRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Models\EProviderReview;

/**
 * Class EProviderReviewController
 * @package App\Http\Controllers\API
 */
class EProviderReviewAPIController extends Controller
{
    /** @var  EProviderReviewRepository */
    private $eProviderReviewRepository;

    public function __construct(EProviderReviewRepository $eProviderReviewRepo)
    {
        $this->eProviderReviewRepository = $eProviderReviewRepo;
    }

    /**
     * Display a listing of the eProviderReview.
     * GET|HEAD /eProviderReviews
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $this->eProviderReviewRepository->pushCriteria(new RequestCriteria($request));
            if (auth()->check()) {
                $this->eProviderReviewRepository->pushCriteria(new EProviderReviewsOfUserCriteria(auth()->id()));
            }
            $this->eProviderReviewRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $eProviderReviews = $this->eProviderReviewRepository->all();
        // dd($eProviderReviews);
        $this->filterCollection($request, $eProviderReviews);

        return $this->sendResponse($eProviderReviews->toArray(), 'E Provider Reviews retrieved successfully');
    }

    /**
     * Display the specified EProviderReview.
     * GET|HEAD /EProviderReviews/{id}
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $this->eProviderReviewRepository->pushCriteria(new RequestCriteria($request));
            $this->eProviderReviewRepository->pushCriteria(new LimitOffsetCriteria($request));

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $eProviderReview = $this->eProviderReviewRepository->findWithoutFail($id);
        if (empty($eProviderReview)) {
            return $this->sendError(__('lang.not_found', ['operator' => __('lang.e_provider_review')]));
        }
        $this->filterModel($request, $eProviderReview);

        return $this->sendResponse($eProviderReview->toArray(), 'E Provider Review retrieved successfully');
    }

    /**
     * Store a newly created Review in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $uniqueInput = $request->only("user_id", "e_provider_id");
        $otherInput = $request->except("user_id", "e_provider_id");
        // dd($otherInput, $uniqueInput);
        try {
            // $review = new EProviderReview;
            // $review->fill($request->all());
            // $review->save();
            $review = $this->eProviderReviewRepository->updateOrCreate($uniqueInput, $otherInput);
            // dd($review);
        } catch (ValidatorException $e) {
            return $this->sendError(__('lang.not_found', ['operator' => __('lang.e_provider_review')]));
        }
        // dd($review);

        return $this->sendResponse($review->toArray(), __('lang.saved_successfully', ['operator' => __('lang.e__provider_review')]));
    }
}

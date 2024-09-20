<?php
/*
 * File name: EProviderReviewsOfUserCriteria.php
 * Last modified: 2021.03.23 at 11:47:29
 * Copyright (c) 2021
 */

namespace App\Criteria\EProviderReviews;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EProviderReviewsOfUserCriteria.
 *
 * @package namespace App\Criteria\EProviderReviews;
 */
class EProviderReviewsOfUserCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private $userId;

    /**
     * EProviderReviewsOfUserCriteria constructor.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return $model->select('e_provider_reviews.*');
        } else if (auth()->check() && auth()->user()->hasRole('provider')) {
            return $model->join("e_providers", "e_providers.id", "=", "e_provider_reviews.e_provider_id")
                ->join("e_provider_users", "e_provider_users.e_provider_id", "=", "e_providers.id")
                ->where('e_provider_users.user_id', $this->userId)
                ->groupBy('e_provider_reviews.id')
                ->select('e_provider_reviews.*');
        } else if (auth()->check() && auth()->user()->hasRole('customer')) {
            return $model->newQuery()->where('e_provider_reviews.user_id', $this->userId)
                ->select('e_provider_reviews.*');
        } else {
            return $model->select('e_provider_reviews.*');
        }
    }
}

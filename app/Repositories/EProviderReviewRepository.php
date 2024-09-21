<?php
/*
 * File name: EProviderReviewRepository.php
 * Last modified: 2021.01.23 at 21:01:19
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\EProviderReview;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class EProviderReviewRepository
 * @package App\Repositories
 * @version January 23, 2021, 7:42 pm UTC
 *
 * @method EProviderReview findWithoutFail($id, $columns = ['*'])
 * @method EProviderReview find($id, $columns = ['*'])
 * @method EProviderReview first($columns = ['*'])
 */
class EProviderReviewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'review',
        'rate',
        'user_id',
        'e_provider_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EProviderReview::class;
    }
}

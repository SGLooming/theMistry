<?php
/**
 * File name: CouponRepository.php
 * Last modified: 2021.01.03 at 15:29:51
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\Coupon;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CouponRepository
 * @package App\Repositories
 * @version August 23, 2020, 6:10 pm UTC
 *
 * @method Coupon findWithoutFail($id, $columns = ['*'])
 * @method Coupon find($id, $columns = ['*'])
 * @method Coupon first($columns = ['*'])
 */
class CouponRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'discount',
        'discount_type',
        'description',
        'eservice_id',
        'market_id',
        'category_id',
        'expires_at',
        'enabled'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Coupon::class;
    }
}

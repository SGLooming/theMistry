<?php
/**
 * File name: DiscountableRepository.php
 * Last modified: 2021.01.03 at 15:29:51
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\Discountable;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class DiscountableRepository
 * @package App\Repositories
 * @version July 24, 2018, 9:13 pm UTC
 *
 * @method Discountable findWithoutFail($id, $columns = ['*'])
 * @method Discountable find($id, $columns = ['*'])
 * @method Discountable first($columns = ['*'])
 */
class DiscountableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'custom_field_id',
        'customizable_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Discountable::class;
    }
}

<?php
/*
 * File name: AddressRepository.php
 * Last modified: 2021.02.16 at 10:54:15
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\Address;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class AddressRepository
 * @package App\Repositories
 * @version January 13, 2021, 8:02 pm UTC
 *
 * @method Address findWithoutFail($id, $columns = ['*'])
 * @method Address find($id, $columns = ['*'])
 * @method Address first($columns = ['*'])
 */
class AddressRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
        'address',
        'latitude',
        'longitude',
        'default',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Address::class;
    }
}

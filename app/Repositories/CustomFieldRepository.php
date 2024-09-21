<?php
/**
 * File name: CustomFieldRepository.php
 * Last modified: 2021.01.03 at 15:29:51
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\CustomField;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CustomFieldRepository
 * @package App\Repositories
 * @version July 24, 2018, 9:13 pm UTC
 *
 * @method CustomField findWithoutFail($id, $columns = ['*'])
 * @method CustomField find($id, $columns = ['*'])
 * @method CustomField first($columns = ['*'])
 */
class CustomFieldRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'disabled',
        'required',
        'in_table',
        'bootstrap_column',
        'order',
        'custom_field_model'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CustomField::class;
    }
}

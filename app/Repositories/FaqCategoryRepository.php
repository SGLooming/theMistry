<?php
/**
 * File name: FaqCategoryRepository.php
 * Last modified: 2021.01.03 at 15:29:51
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\FaqCategory;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FaqCategoryRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @method FaqCategory findWithoutFail($id, $columns = ['*'])
 * @method FaqCategory find($id, $columns = ['*'])
 * @method FaqCategory first($columns = ['*'])
 */
class FaqCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FaqCategory::class;
    }
}

<?php
/**
 * File name: FaqRepository.php
 * Last modified: 2021.01.03 at 15:29:51
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\Faq;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FaqRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:39 pm UTC
 *
 * @method Faq findWithoutFail($id, $columns = ['*'])
 * @method Faq find($id, $columns = ['*'])
 * @method Faq first($columns = ['*'])
 */
class FaqRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'question',
        'answer',
        'faq_category_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Faq::class;
    }
}

<?php
/*
 * File name: GalleryRepository.php
 * Last modified: 2021.01.24 at 17:39:22
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\Gallery;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class GalleryRepository
 * @package App\Repositories
 * @version January 23, 2021, 8:15 pm UTC
 *
 * @method Gallery findWithoutFail($id, $columns = ['*'])
 * @method Gallery find($id, $columns = ['*'])
 * @method Gallery first($columns = ['*'])
 */
class GalleryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
        'e_provider_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Gallery::class;
    }
}

<?php
/**
 * File name: NotificationRepository.php
 * Last modified: 2021.01.03 at 15:28:32
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\Notification;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class NotificationRepository
 * @package App\Repositories
 * @version September 4, 2019, 10:30 am UTC
 *
 * @method Notification findWithoutFail($id, $columns = ['*'])
 * @method Notification find($id, $columns = ['*'])
 * @method Notification first($columns = ['*'])
 */
class NotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'read_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notification::class;
    }
}

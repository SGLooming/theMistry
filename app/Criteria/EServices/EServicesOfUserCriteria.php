<?php
/*
 * File name: EServicesOfUserCriteria.php
 * Last modified: 2021.03.23 at 11:38:55
 * Copyright (c) 2021
 */

namespace App\Criteria\EServices;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\ProviderService;

/**
 * Class EServicesOfUserCriteria.
 *
 * @package namespace App\Criteria\EServices;
 */
class EServicesOfUserCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private $userId;

    /**
     * EServicesOfUserCriteria constructor.
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
        if (auth()->check() && auth()->user()->hasRole('provider')) {
            // ===========get all the services related to the providers
            $services_ids = ProviderService::where('provider_id',$this->userId)->pluck('service_id')->toArray();
            \Log::info(json_encode($services_ids));
            return $model->whereIn('id',$services_ids)->select('e_services.*')->groupBy('e_services.id');
        } else {
            // get all the servies from services table.
            return $model->select('e_services.*')->groupBy('e_services.id');
        }
    }
}

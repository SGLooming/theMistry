<?php
/*
 * File name: EProviderDataTable.php
 * Last modified: 2021.11.24 at 19:18:10
 * Copyright (c) 2022
 */

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\EProvider;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class EProviderDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('image', function ($eProvider) {
                return getMediaColumn($eProvider, 'image');
            })
            ->editColumn('name', function ($eProvider) {
                if ($eProvider['featured']) {
                    return $eProvider->name . "<span class='badge bg-" . setting('theme_color') . " p-1 m-2'>" . trans('lang.e_service_featured') . "</span>";
                }
                return $eProvider->name;
            })
            // ->editColumn('e_provider_type.name', function ($eProvider) {
            //     return getLinksColumnByRouteName([$eProvider->eProviderType], "eProviderTypes.edit", 'id', 'name');
            // })
            // ->editColumn('users', function ($eProvider) {
            //     return getLinksColumnByRouteName($eProvider->users, 'users.edit', 'id', 'name');
            // })
            
            ->editColumn('addresses', function ($eProvider) {
                return getLinksColumnByRouteName($eProvider->addresses, 'addresses.edit', 'id', 'address');
            })
            // ->editColumn('taxes', function ($eProvider) {
            //     return getLinksColumnByRouteName($eProvider->taxes, 'taxes.edit', 'id', 'name');
            // })
            ->editColumn('available', function ($eProvider) {
                return getBooleanColumn($eProvider, 'available');
            })
            ->editColumn('tm_certified', function ($eProvider) {
                if($eProvider->tm_certified){
                    return  "<span class='badge badge-success'>" . trans('lang.yes') . "</span>";
                }
                return  "<span class='badge badge-danger'>" . trans('lang.no') . "</span>";
            })
            ->editColumn('aadhaar_no', function ($eProvider) {
                return $eProvider->aadhaar_no;
            })
            // ->editColumn('dob', function ($eProvider) {
            //     return $eProvider->dob;
            // })
            // ->editColumn('gender', function ($eProvider) {
            //     return $eProvider->gender;
            // })
            // ->editColumn('permanent_address', function ($eProvider) {
            //     return $eProvider->permanent_address;
            // })
            // ->editColumn('certification', function ($eProvider) {
            //     return $eProvider->certification;
            // })
            // ->editColumn('education', function ($eProvider) {

            //     return $eProvider->education;
            // })
            // ->editColumn('services', function ($eProvider) {

            //     return $eProvider->services;
            // })
            ->editColumn('work_address', function ($eProvider) {

                return $eProvider->work_address;
            })
            // ->editColumn('pincode', function ($eProvider) {

            //     return $eProvider->pincode;
            // })
            // ->editColumn('years_of_experience', function ($eProvider) {

            //     return $eProvider->years_of_experience;
            // })
            ->editColumn('experience', function ($eProvider) {

                if ($eProvider->experience) {
                    return "<span class='badge badge-success'>" . trans('lang.yes') . "</span>";
                } else {
                    return "<span class='badge badge-danger'>" . trans('lang.no') . "</span>";
                }
            })
            ->editColumn('accepted', function ($eProvider) {
                return getBooleanColumn($eProvider, 'accepted');
            })
            ->editColumn('updated_at', function ($eProvider) {
                return getDateColumn($eProvider);
            })
            ->addColumn('action', 'e_providers.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'image',
                'title' => trans('lang.e_provider_image'),
                'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false,
            ],
            [
                'data' => 'name',
                'title' => trans('lang.e_provider_name'),

            ],
            // [
            //     'data' => 'e_provider_type.name',
            //     'name' => 'eProviderType.name',
            //     'title' => trans('lang.e_provider_e_provider_type_id'),

            // ],
            // [
            //     'data' => 'users',
            //     'title' => trans('lang.e_provider_users'),
            //     'searchable' => false,
            //     'orderable' => false
            // ],
            // [
            //     'data' => 'phone_number',
            //     'title' => trans('lang.e_provider_phone_number'),

            // ],
            [
                'data' => 'mobile_number',
                'title' => trans('lang.e_provider_mobile_number'),

            ],
            [
                'data' => 'addresses',
                'title' => trans('lang.e_provider_addresses'),
                'searchable' => false,
                'orderable' => false
            ],
            [
                'data' => 'availability_range',
                'title' => trans('lang.e_provider_availability_range'),

            ],
            // [
            //     'data' => 'taxes',
            //     'title' => trans('lang.e_provider_taxes'),
            //     'searchable' => false,
            //     'orderable' => false
            // ],
            [
                'data' => 'available',
                'title' => trans('lang.e_provider_available'),

            ],[
                'data'=>'tm_certified',
                'title'=>trans('lang.e_provider_tm_certified'),
            ],
            [
                'data' => 'aadhaar_no',
                'title' => trans('auth.aadhaar_number'),

            ],
            //  [
            //     'data' => 'dob',
            //     'title' => trans('auth.dob'),

            // ],
            //  [
            //     'data' => 'gender',
            //     'title' => trans('auth.gender'),

            // ],
            //  [
            //     'data' => 'permanent_address',
            //     'title' => trans('auth.permanent_address'),

            // ], 
            // [
            //     'data' => 'certification',
            //     'title' => trans('auth.certification'),

            // ],
            // [
            //     'data' => 'education',
            //     'title' => trans('auth.education'),

            // ], 
            // [
            //     'data' => 'services',
            //     'title' => trans('auth.service'),

            // ],
            [
                'data' => 'work_address',
                'title' => trans('auth.work_address'),

            ],
            //  [
            //     'data' => 'pincode',
            //     'title' => trans('auth.pincode'),

            // ],
            //  [
            //     'data' => 'years_of_experience',
            //     'title' => trans('auth.year_of_experience'),

            // ], 
            //  [
            //     'data' => 'experience',
            //     'title' => trans('auth.experience'),

            // ], 
            [
                'data' => 'accepted',
                'title' => trans('lang.e_provider_accepted'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.address_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(EProvider::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', EProvider::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.e_provider_' . $field->name),
                    'orderable' => false,
                    'searchable' => false,
                ]]);
            }
        }
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param EProvider $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EProvider $model): \Illuminate\Database\Eloquent\Builder
    {
        if (auth()->user()->hasRole('admin')) {
            return $model->newQuery()->where('accepted',1)->with("eProviderType")->select("e_providers.*")->orderBy('id','DESC');
        } else if (auth()->user()->hasRole('provider')) {
            return $model->newQuery()
                ->with("eProviderType")
                ->where('accepted',1)
                ->join("e_provider_users", "e_provider_id", "=", "e_providers.id")
                ->where('e_provider_users.user_id', auth()->id())
                ->groupBy("e_providers.id")
                ->select("e_providers.*")->orderBy('id','DESC');
        } else {
            return $model->newQuery()->where('accepted',1)->with("eProviderType")->select("e_providers.*")->orderBy('id','DESC');
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'),
                [
                    'language' => json_decode(
                        file_get_contents(
                            base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ),
                        true
                    ),
                    'fixedColumns' => [],
                ]
            ));
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'e_providersdatatable_' . time();
    }
}

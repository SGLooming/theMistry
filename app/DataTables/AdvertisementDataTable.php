<?php
/*
 * File name: advertisementDataTable.php
 * Last modified: 2021.04.12 at 09:17:55
 * Copyright (c) 2021
 */

namespace App\DataTables;

use App\Models\Advertisement;
use App\Models\CustomField;
use App\Models\Post;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class AdvertisementDataTable extends DataTable
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
            ->editColumn('image', function ($slide) {
                return getMediaColumn($slide, 'image');
            })
            ->editColumn('description', function ($advertisement) {
                return getStripedHtmlColumn($advertisement, 'description');
            })
            ->editColumn('title', function ($advertisement) {
                return $advertisement->title;
            })
            ->editColumn('featured', function ($advertisement) {
                return getBooleanColumn($advertisement, 'featured');
            })
            ->editColumn('updated_at', function ($advertisement) {
                return getDateColumn($advertisement, 'updated_at');
            })
            ->addColumn('action', 'advertisement.datatables_actions')
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
                'title' => trans('lang.slide_image'),
                'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false,
            ],
            [
                'data' => 'title',
                'title' => trans('lang.advertisement_title'),

            ],
            [
                'data' => 'description',
                'title' => trans('lang.advertisement_description'),

            ],
            [
                'data' => 'featured',
                'title' => trans('lang.advertisement_featured'),
            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.advertisement_updated_at'),
                'searchable' => false,
            ]
        ];

        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param advertisement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Advertisement $model)
    {
        return $model->newQuery()->select("advertisement.*")->orderBy('id', 'DESC');
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
                    )
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
        return 'adsdatatable_' . time();
    }
}

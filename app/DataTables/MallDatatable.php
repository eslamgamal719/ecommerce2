<?php

namespace App\DataTables;

use App\Admin;
use App\Models\Mall;
use App\Models\Manufacturer;
use App\Models\TradeMark;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MallDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('checkbox', 'dashboard.malls.btn.checkbox')
            ->addColumn('edit', 'dashboard.malls.btn.edit')
            ->addColumn('delete', 'dashboard.malls.btn.delete')
             ->rawColumns([
                 'edit',
                 'delete',
                 'checkbox',
              ]);
    }


    public function query()
    {
        return Mall::Query()->with('country_id');
    }




    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
      return $this->builder()
          ->columns($this->getColumns())
          ->minifiedAjax()
         // ->addAction(['width' => '80px'])
          ->parameters([
              'dom' => 'Blfrtip',
              'lengthMenu' => [[10,25,50,100], [10,25,50,__('admin.all_record')]],
              'buttons' => [
                 [ 'text' => '<i class="fa fa-plus"></i>' . trans('admin.create'),'className' => 'btn btn-info',
                     "action" => "function(){
                        window.location.href = '" . \URL::current() . "/create';
                 }"],
                 ['extend' => 'print', 'className' => 'btn btn-primary', 'text' => '<i class="fa fa-print"></i>'],
                 ['extend' => 'csv', 'className' => 'btn btn-info', 'text' => '<i class="fa fa-file"></i> ' . trans('admin.ex_csv')],
                 ['extend' => 'excel', 'className' => 'btn btn-success', 'text' => '<i class="fa fa-file"></i> ' . trans('admin.ex_excel')],
                 ['extend' => 'reload', 'className' => 'btn btn-default', 'text' => '<i class="fa fa-refresh"></i>'],
                  [ 'text' => '<i class="fa fa-trash"></i>',  'className' => 'btn btn-danger delBtn' ],
             ],

              'initComplete' => "function () {
                     this.api().columns([2,3,4]).every(function () {
                        var column = this;
                        var input = document.createElement('input');
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                          });
                        });
                    }",

             'language' => datatable_lang(),

          ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'name' => 'checkbox',
                'data' => 'checkbox',
                'title' => '<input type="checkbox" class="check_all" onclick="check_all()">',
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'name' => 'id',
                'data' => 'id',
                'title' => '#',
            ],
            [
                'name' => 'name_ar',
                'data' => 'name_ar',
                'title' => trans('admin.name_ar'),
            ],
            [
                'name' => 'name_en',
                'data' => 'name_en',
                'title' => trans('admin.name_en'),
            ],
            [
                'name' => 'mobile',
                'data' => 'mobile',
                'title' => trans('admin.mobile'),
            ],
            [
                'name' => 'country_id.country_name_' . lang(),
                'data' => 'country_id.country_name_' . lang(),
                'title' => trans('admin.country_id'),
            ],
            [
                'name' => 'created_at',
                'data' => 'created_at',
                'title' => trans('admin.created_at'),
            ],
            [
                'name' => 'updated_at',
                'data' => 'updated_at',
                'title' => trans('admin.updated_at'),
            ],
            [
                'name' => 'edit',
                'data' => 'edit',
                'title' => trans('admin.edit'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'name' => 'delete',
                'data' => 'delete',
                'title' => trans('admin.delete'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'malls' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\KindCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KindCategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('show', function($model){
                return '<a href="'. route('admin.kindcategory.kind.index', $model) .'" class="btn btn-sm btn-icon item-edit m-2"><button type="button" class="btn btn-label-primary"><span class="tf-icons bx bxs-show me-1"></span></button></a>';
            })
            ->editColumn('parent_id', function($model){
                return $model->parent->title ?? null;
            })
            ->rawColumns(['show'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(KindCategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kindcategory-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('models.kindCategory.id')),
            Column::make('title')->title(__('models.kindCategory.title')),
            Column::make('key')->title(__('models.kindCategory.key')),
            Column::make('label_value_1')->title(__('models.kindCategory.label_value_1')),
            Column::make('label_value_2')->title(__('models.kindCategory.label_value_2')),
            Column::make('parent_id')->title(__('models.kindCategory.parent_id')),
            Column::make('created_at')->title(__('global.created_at')),
            Column::make('updated_at')->title(__('global.updated_at')),
            Column::make('show')->title(__('global.show')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'KindCategory_' . date('YmdHis');
    }
}

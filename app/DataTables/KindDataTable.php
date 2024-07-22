<?php

namespace App\DataTables;

use App\Models\Kind;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KindDataTable extends DataTable
{

    public $kindCategory;

    public function __construct(Request $request)
    {
        $kindCategory = $request->route('kindcategory');
        $this->kindCategory = $kindCategory;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('actions', function($model){
                $delete = route('admin.kindcategory.kind.destroy', [$this->kindCategory, $model]);
                return '<div class="d-inline-block">
                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>
                <ul class="dropdown-menu dropdown-menu-end m-0">
                <li><button onclick="DestroyField(`'.$delete.'`,`#kind-table`)" class="dropdown-item text-danger delete-record">حذف</button></li>
                </ul>
                </div>
                <a href="'. route('admin.kindcategory.kind.edit', [$this->kindCategory, $model]) .'" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>';
            })
            ->addColumn('childs', function($model){
                if ($this->kindCategory->hasChilds($this->kindCategory->id)) {
                    $route = route('admin.kindcategory.kind.index', [$this->kindCategory->child($this->kindCategory->id)->id, 'parent_id' => $model]);
                    return '<a href="'. $route .'" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-show"></i></a>';
                }
                return '';
            })
            ->editColumn('parent_id', function($model){
                return $model->parent->value_1 ?? null;
            })
            ->editColumn('is_active', function($model){
                return __('global.is_active.' . $model->is_active);
            })
            ->rawColumns(['childs', 'actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Kind $model): QueryBuilder
    {
        if (isset($_GET['parent_id']))
        {
            return $model->newQuery()->where('kind_category_id',$this->request->route('kindcategory')->id)->where('parent_id', $_GET['parent_id']);
        }
        return $model->newQuery()->where('kind_category_id',$this->request->route('kindcategory')->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kind-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('models.kind.id')),
            Column::make('key')->title($this->kindCategory->label_key),
            Column::make('value_1')->title($this->kindCategory->label_value_1),
            Column::make('value_2')->title($this->kindCategory->label_value_2 ?? 'مقدار دوم'),
            Column::make('parent_id')->title(__('models.kind.parent_id')),
            Column::make('is_active')->title(__('models.kind.is_active')),
            Column::make('childs')->title(__('models.kind.childs'))->orderable(false),
            Column::make('created_at')->title(__('global.created_at')),
            Column::make('updated_at')->title(__('global.updated_at')),
            Column::make('actions')->title(__('global.actions'))->type('action')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Kind_' . date('YmdHis');
    }
}

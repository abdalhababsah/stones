<?php

namespace App\DataTables\Catalog;
use Yajra\DataTables\EloquentDataTable;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query, DataTables $dataTables): EloquentDataTable
    {

        return $dataTables->eloquent($query)

            ->addColumn('action', function (Product $product) {
                return view('pages.catalog.products.columns._actions', compact('product'));
            })
            ->editColumn('status', function ($product) {
                $badgeColors = ['active' => 'success', 'inactive' => 'danger'];
                return '<span class="badge bg-' . ($badgeColors[$product->status] ?? 'secondary') . '">' . ucfirst($product->status) . '</span>';
            })
            ->editColumn('category_type', function ($product) {
                $badgeColors = ['hot' => 'success', 'new' => 'danger','featured'=>'info'];
                return '<span class="badge bg-' . ($badgeColors[$product->category_type] ?? 'secondary') . '">' . ucfirst($product->category_type) . '</span>';
            })
            ->addColumn('inventory', function ($product) {
                return $product->variants->map(function ($variant) {
                    return $variant->inventory ? $variant->inventory->quantity_available : 'N/A';
                })->implode('<br>');
            })
            ->editColumn('images', function ($product) {
                return $product->images->map(function ($image) {
                    return '<img src="' . Storage::disk('s3')->url($image->image_path) . '" class="img-fluid img-thumbnail" style="max-height: 50px;"/>';
                })->implode('&nbsp;');
            })
            ->addColumn('category', function ($product) {
                return $product->category->name_en ?? 'N/A';
            })
            ->addColumn('dimensions', function ($product) {
                return $product->dimension ? "{$product->dimension->length} x {$product->dimension->width} x {$product->dimension->height} {$product->dimension->dimension_unit}" : 'N/A';
            })
            ->filter(function ($query) {
                if (request()->has('search') && $search = request()->get('search')['value']) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name_en', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhere('category_type', 'like', "%{$search}%")
                            ->orWhereHas('category', function ($query) use ($search) {
                                $query->where('name_en', 'like', "%{$search}%");
                            })
                            ->orWhereHas('dimension', function ($query) use ($search) {
                                $query->where('length', 'like', "%{$search}%")
                                    ->orWhere('width', 'like', "%{$search}%")
                                    ->orWhere('height', 'like', "%{$search}%");
                            })
                            ->orWhereHas('images', function ($query) use ($search) {
                                $query->where('image_path', 'like', "%{$search}%");
                            });
                    });
                }
            })
            ->rawColumns(['action', 'status', 'images', 'inventory', 'category', 'category_type', 'dimensions']);
    }

    public function query(Product $model): QueryBuilder
    {
        return $model->with(['variants.inventory', 'images', 'category', 'dimension', 'seo'])->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Brtip')
            ->orderBy(1)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0');
    }

    protected function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->visible(false),
            Column::make('name_en')->title('Name'),
            Column::make('images')->title('Images')->addClass('text-center'),
            Column::make('inventory')->title('Inventory'),
            Column::make('category')->title('Category'),
            Column::make('category_type')->title('Category Type'),
            Column::make('status')->title('Status'),

            Column::make('dimensions')->title('Dimensions'),
            Column::computed('action')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}

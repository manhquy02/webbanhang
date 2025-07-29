<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::join('categories','products.category_id','=','categories.id')
        ->select(
            'products.id',
            'products.name_product',
            'products.image',
            'categories.name as category_name',
            'products.stock',
            'products.price',
            
        )
        ->get();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Tên sản phẩm',
            'Ảnh',
            'Danh mục',
            'Số lượng',
            'Giá',
            
        ];
    }
}

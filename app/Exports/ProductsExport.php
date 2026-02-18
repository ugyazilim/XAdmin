<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Category',
            'Name',
            'SKU',
            'Price',
            'Stock',
            'Status',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->category->name ?? '',
            $product->name,
            $product->sku ?? '',
            $product->price,
            $product->stock,
            $product->is_visible ? 'Visible' : 'Hidden',
        ];
    }
}


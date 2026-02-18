<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?Product
    {
        $category = Category::where('name', $row['category'])->first();

        if (!$category) {
            return null;
        }

        return new Product([
            'category_id' => $category->id,
            'name' => $row['name'] ?? '',
            'slug' => \Illuminate\Support\Str::slug($row['name'] ?? ''),
            'price' => $row['price'] ?? 0,
            'sku' => $row['sku'] ?? null,
            'stock' => $row['stock'] ?? 0,
            'is_visible' => isset($row['status']) && strtolower($row['status']) === 'visible',
        ]);
    }
}


<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        private array $filters = []
    ) {
    }

    public function collection()
    {
        $query = Order::where('payment_status', 'paid');

        if (isset($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (isset($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Date',
            'Customer',
            'Subtotal',
            'Tax',
            'Discount',
            'Total',
            'Status',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('Y-m-d H:i:s'),
            $order->customer_name ?? 'N/A',
            $order->subtotal,
            $order->tax_amount,
            $order->discount_amount,
            $order->total,
            $order->status,
        ];
    }
}


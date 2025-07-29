<?php

namespace App\Exports;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::select('id','created_at','receiver_Name','phone','total_price')->get();

    }

    public function headings():array
    {
        return [
            'Id',
            'Ngày đặt',
            'Tên',
            'SĐT',
            'Giá'
        ];
    }
}

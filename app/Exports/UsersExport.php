<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\User;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('id','username','email','role','permission_level')->get();
    }

    public function headings():array 
    {
        return [
            'Id',
            'Tên người dùng',
            'Email',
            'Vai trò',
            'Quyền'
        ];
    }
}

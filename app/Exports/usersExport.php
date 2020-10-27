<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class usersExport implements WithHeadings,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return User::all();
        $usersData = User::select('name','email','city','address')->where('status',1)->orderBy('id','Desc')->get();
        return $usersData;
    }

    public function headings(): array
    {
        return['Nom','Email','Ville','Adresse'];
    }
    
}

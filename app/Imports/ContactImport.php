<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ContactImport implements ToModel, WithCalculatedFormulas
{
    use Importable;
    public function model(array $row)
    {
        if(!array_filter($row)) {
            return null;
        }

        return new Contact([
            'code' =>$row[0],
            'nation' =>$row[1],
            'taxId' =>$row[2],
            'branch' =>$row[3],
            'busType' =>$row[4],
            'busCateType' =>$row[5],
            'title' =>$row[6],
            'firstName' =>$row[7],
            'lastName' =>$row[8],
            'contactname' =>$row[9],
            'address' =>$row[10],
            'subdistrict' =>$row[11],
            'district' =>$row[12],
            'province' =>$row[13],
            'country' =>$row[14],
            'postcode' =>$row[15],
            'phone' =>$row[16],
            'email' =>$row[17],
            'website' =>$row[18],
            'fax' =>$row[19],
            'bank' =>$row[20],
            'bankName' =>$row[21],
            'bankNumber' =>$row[22],
            'bankBranch' =>$row[23]
        ]);
    }
}

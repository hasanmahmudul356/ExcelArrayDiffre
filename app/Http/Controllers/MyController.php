<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MyController extends Controller
{
    public function importExportView()
    {
        return view('import');
    }


    public function import()
    {
        $collection = Excel::toCollection(new UsersImport, request()->file('file'));
        $first_column = request()->input('first_column') ? request()->input('first_column') : 0;
        $second_column = request()->input('second_column') ? request()->input('second_column') : 2;
        if (isset($collection[$first_column])){
            $all_data = collect($collection[0])->toArray();
            $dataList1 = [];
            $dataList2 = [];
            foreach ($all_data as $singleData){
                if (isset($singleData[$first_column])){
                    $dataList1[] = $singleData[$first_column];
                }
                if (isset($singleData[$second_column])){
                    $dataList2[] = $singleData[$second_column];
                }
            }

            $data['loan_codes'] = array_diff($dataList1, $dataList2);
            return view('diffrent', $data);
        }
    }
}

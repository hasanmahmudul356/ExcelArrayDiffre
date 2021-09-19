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


    public function import(Request $request)
    {
        if (!request()->file('file')){
            $data['loan_codes'] = ['You Must Select File'];
            return view('diffrent', $data);
        }

        $collection = Excel::toCollection(new UsersImport, request()->file('file'));
        $first_column = $request->first_column && $request->first_column > 0 ? $request->first_column-1 : 0;
        $second_column = $request->second_column && $request->second_column ? $request->second_column-1 : 2;


        if (isset($collection[0])){
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

            if (count($data['loan_codes']) > 0){
                return view('diffrent', $data);
            }else{
                $data['loan_codes'] = ['No Diffrence Found'];
                return view('diffrent', $data);
            }
        }else{
            $data['loan_codes'] = ['Column Number not match'];
            return view('diffrent', $data);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Data;
use App\Evaluate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class DataController extends Controller
{
    public function getData(Request $request){
        $date = Carbon::parse($request->date)->toDateString();
        $data = Data::with('evaluates')->whereDate('created_at', '=', $date)->get();

        $dataLast = Data::with('evaluates')->orderBy('id', 'desc')->first();
        
        if($dataLast)
            $lastId = $dataLast->id;
        else
            $lastId = 1;

        return response()->json([
            'statusCode' => 201,
            'length' => count($data),
            'datas' => $data,
            'lastId' => $lastId + 1,
        ]);
    }

    public function saveData(Request $request){
        $datas = array();
        $date = Carbon::parse($request->date)->toDateString();

        foreach (Data::select('id')->whereDate('created_at', '=', $date)->get() as $item){
            array_push($datas, $item->id);
        }

        $listData = $request->datas;
        $listDataId = array();
        
        foreach ($listData as $item){
            array_push($listDataId, $item['id']);
        }

        $exceptArray = array_diff($datas, $listDataId);
        
        foreach ($exceptArray as $id) {
            Data::whereId($id)->delete();
            Evaluate::where('data_id')->delete();
        }

        foreach ($listData as $item){

            $data = Data::updateOrCreate([
                'id' => $item['id'],
            ],[
                'specialty' => $item['specialty'],
                'name' => $item['name'],
                'age' => $item['age'],
                'size' => $item['size'],
                'weight' => $item['weight'],
                'total' => $item['total'],
                'average' => $item['average'],
                'result' => $item['result'],
            ]);

            foreach ($item['listEvaluate'] as $evaluate){
                if($evaluate['repTiemp'] != null || $evaluate['note'] != null || $evaluate['pts'] != null)
                    Evaluate::updateOrCreate([
                        'data_id' => $data['id'],
                        'type'  => $evaluate['id'],
                    ],[
                        'repTiemp' => $evaluate['repTiemp'],
                        'note' => $evaluate['note'],
                        'pts' => $evaluate['pts'],
                    ]);
            }

        }

        return response()->json([
            'statusCode' => 201,
        ]);
    }

    public function getPDF(Request $request)
    {
        $name = $request->name;
        $dateQueryInitial = Carbon::parse($request->date)->toDateString();
        $dateQueryFinal = Carbon::parse($request->date)->addDay()->toDateString();
        $dateSelect = Carbon::parse($request->date)->format('d/m/Y');
        $date = Carbon::now()->format('d/m/Y');
        $dataRecord = Data::with('evaluates')->whereDate('created_at', '>=', $dateQueryInitial)->whereDate('created_at', '<=', $dateQueryFinal)->get();
        /* return view('report.record', compact('name', 'date', 'dataRecord')); */
        $customPaper = array(0,0,1000,2000);
        $pdf = \PDF::loadView('report.record', compact('name', 'dateSelect', 'date', 'dataRecord'))->setPaper($customPaper, 'landscape');
        return $pdf->download('record.pdf');

    }
}

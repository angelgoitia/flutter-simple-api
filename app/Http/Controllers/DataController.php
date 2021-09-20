<?php

namespace App\Http\Controllers;

use App\Data;
use App\Evaluate;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getData(Request $request){
        $data = Data::with('evaluates')->get();

        return response()->json([
            'statusCode' => 201,
            'length' => count($data),
            'datas' => $data,
        ]);
    }

    public function saveData(Request $request){
        $datas = array();

        foreach (Data::select('id')->get() as $item){
            array_push($datas, $item->id);
        }

        $listData = json_decode($request->datas);
        $listDataId = array();
        
        foreach ($listData as $item){
            array_push($listDataId, $item->id);
        }

        $exceptArray = array_diff($datas, $listDataId);
        foreach ($exceptArray as $id) {
            Data::whereId($id)->delete();
            Evaluate::where('data_id')->delete();
        }

        foreach ($listData as $item){
            $data = Data::updateOrCreate([
                'id' => $item->id,
            ],[
                'specialty' => $item->specialty,
                'name' => $item->name,
                'age' => $item->age,
                'size' => $item->size,
                'weight' => $item->weight,
                'total' => $item->total,
                'average' => $item->average,
                'result' => $item->result,
            ]);

            foreach (json_decode($item->listEvaluate) as $evaluate){
                Evaluate::updateOrCreate([
                    'data_id' => $data->id,
                    'type'  => $evaluate->id,
                ],[
                    'repTiemp' => $evaluate->repTiemp,
                    'note' => $evaluate->note,
                    'pts' => $evaluate->pts,
                ]);
            }

        }

        return response()->json([
            'statusCode' => 201,
        ]);
    }
}

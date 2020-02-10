<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\{Product, Stock};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function reportMobile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'start'  =>  'nullable|date',
            'end'  =>  'nullable|date',
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }
        
        $day0 = date('Y-01-01 00:00:00'); #set first day of the this year
        $day1 = date('Y-m-d 23:59:59'); #set dateNow (today)

        $dayStart = date($request->start. ' 00:00:00');
        $dayEnd = date($request->end. ' 23:59:59');

        (!$request->start) ? $from = $day0 : $from = $dayStart;
        (!$request->end) ? $to = $day1 : $to = $dayEnd;

        $products = Product::all();

        foreach ($products as $index => $p) {
            $p['f_init'] = $p->getStockBeforeDate($from);
            $p['f_init'] ?? $p['f_init'] = $p->stock; 
            $p['f_changes'] = $p->getStockOnRange($from, $to);
            $p['f_add'] = $p['f_changes']['add'];
            $p['f_min'] = $p['f_changes']['min'];
            $p['f_total'] = $p['f_init'] + $p['f_add'] - $p['f_min'];
        }

        $success['status'] = 'success';
        $success['data'] = $products;
        return response()->json($success);
    }
    public function report(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'start'  =>  'required|date',
            'end'  =>  'required|date',
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }

        $from = date($request->start. ' 00:00:00');
        $to = date($request->end. ' 23:59:59');
        $products = Product::all();
        $data = [];
        
        foreach ($products as $index => $p) {
            $p['f_init'] = $p->getStockBeforeDate($from);
            $p['f_init'] ?? $p['f_init'] = $p->stock; 
            $p['f_changes'] = $p->getStockOnRange($from, $to);
            $p['f_add'] = $p['f_changes']['add'];
            $p['f_min'] = $p['f_changes']['min'];
            $p['f_total'] = $p['f_init'] + $p['f_add'] - $p['f_min'];

            $push = [
                '0' => $index+1,
                '1' => $p->name,
                '2' => $p['f_init'],
                '3' => $p['f_add'],
                '4' => $p['f_min'],
                '5' => $p['f_total'],
            ];
            array_push($data, $push);
        }

        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_id'  =>  'required||exists:products,id',
            'status'  =>  'required|in:in,out',
            'amount'  =>  'required|numeric',
            'desc'  =>  'nullable',
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }
        $stock = new Stock();
        $stock->product_id = $request->product_id;
        $stock->status = $request->status;
        $stock->desc = $request->desc;

        // generate trx code
        $rmdash = str_replace("-","",Carbon::now()->toDateTimeString());
        $rmcolon = str_replace(":","",$rmdash);
        $rmspace = str_replace(" ","",$rmcolon).substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,3);


        $init = Product::where('id', $request->product_id)->get()->first()->stock;
        $sisa = $init;

        $lastStock = Stock::where('product_id', $request->product_id)->get()->last();
        if($lastStock){
          $sisa = $lastStock->remain;
        }

        if($request->status == 'in'){
            $stock->trx_id = 'IN'.$rmspace;
            $stock->increase = $request->amount;
            $stock->decrease = 0;
            $stock->remain = $sisa + $request->amount;
        } else {
            $stock->trx_id = 'OUT'.$rmspace;
            $stock->increase = 0;
            $stock->decrease = $request->amount;
            $stock->remain = $sisa - $request->amount;
        }

        $stock->save();

        $success['status'] = 'success';
        $success['data'] = $stock;
        return response()->json($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return response()->json($stock);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

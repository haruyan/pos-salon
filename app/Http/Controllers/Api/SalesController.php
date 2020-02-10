<?php

namespace App\Http\Controllers\Api;

use Carbon\{Carbon, CarbonPeriod};
use App\{Product};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
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

        // for table -------------------------------------------------------------------------------------------------------------------
        $from = date($request->start. ' 00:00:00');
        $to = date($request->end. ' 23:59:59');
        $table = [];

        // return $request->all();

        $products = Product::with(['stocked' => function($q) use($from, $to) {
            $q
            ->join('transactions' , 'stocks.trx_id' , '=' , 'transactions.trx_number')
            ->select('stocks.*', 'transactions.trx_number')
            ->whereBetween('stocks.created_at',[$from, $to]);
        }])->get();

        foreach ($products as $index => $p) {
            array_push($table, [
                '0' => $index+1,
                '1' => $p->name,
                '2' => $p->stocked->sum('decrease')
            ]);
        }

        // for chart -------------------------------------------------------------------------------------------------------------------
        $ranges = CarbonPeriod::create($request->start, $request->end);
        $info = [];

        foreach ($ranges as $index => $r) {
            $dates = $r->format('Y-m-d');

            $start = date($dates. ' 00:00:00');
            $end = date($dates. ' 23:59:59');
            
            $products = Product::with(['stocked' => function($q) use($start, $end) {
                $q
                ->join('transactions' , 'stocks.trx_id' , '=' , 'transactions.trx_number')
                ->select('stocks.*', 'transactions.trx_number')
                ->whereBetween('stocks.created_at',[$start, $end]);
            }])->get();

            foreach ($products as $p) {
                $p['sold'] = $p->stocked->sum('decrease');
                $p['total_sold'] += $p['sold'];
            }

            $info[] = [
                'date' => $dates,
                'sold' => $products->sum('total_sold')
            ];
        }

        $thisData['table'] = $table;
        $thisData['info'] = $info;
        $thisData['count'] = collect($info)->sum('sold');
        
        return response()->json($thisData);
    }

    public function reportMobile(Request $request)
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

        // for table -------------------------------------------------------------------------------------------------------------------
        $from = date($request->start. ' 00:00:00');
        $to = date($request->end. ' 23:59:59');
        $table = [];

        // return $request->all();

        $products = Product::with(['stocked' => function($q) use($from, $to) {
            $q
            ->join('transactions' , 'stocks.trx_id' , '=' , 'transactions.trx_number')
            ->select('stocks.*', 'transactions.trx_number')
            ->whereBetween('stocks.created_at',[$from, $to]);
        }])->get();

        foreach ($products as $index => $p) {
            $table[] = (object)[
                'name' => $p->name,
                'sold' => $p->stocked->sum('decrease')
            ];
        }

        $thisData['count'] = collect($table)->sum('sold');
        $thisData['table'] = $table;
        
        return response()->json($thisData);
    }
}

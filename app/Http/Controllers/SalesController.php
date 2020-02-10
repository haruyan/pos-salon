<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format( 'Y-m-d' ). ' 23:59:59';
        $lastWeek = Carbon::now()->addDays(-6)->format( 'Y-m-d' ). ' 00:00:00';
        $products = Product::with(['stocked' => function($q) use($today, $lastWeek) {
            $q
            ->join('transactions' , 'stocks.trx_id' , '=' , 'transactions.trx_number')
            ->select('stocks.*', 'transactions.trx_number')
            ->whereBetween('stocks.created_at',[$lastWeek, $today]);
        }])->get();
        
        foreach ($products as $p) {
            $p['total'] = $p->stocked->sum('decrease');
        }
        $count = $products->sum('total');

        // Build an array of the recent week
        $dates = collect();
        foreach( range( -6, 0 ) as $i ) {
            $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $from = date($date. ' 00:00:00');
            $to = date($date. ' 23:59:59');

            $stock = Stock::whereBetween('stocks.created_at',[$from, $to])
                    ->join("transactions" , "stocks.trx_id" , "=" , "transactions.trx_number")
                    ->select('stocks.*', 'transactions.trx_number')
                    ->get();
            $sum = $stock ? $stock->sum('decrease') : 0 ;
        
            $dates->put( $date, $sum );
        }
        
        return view('admin.sales.index', compact('products', 'count', 'dates'));
    }
}

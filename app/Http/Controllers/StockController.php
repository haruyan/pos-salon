<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::with('details')->orderBy('created_at', 'desc')->get();
        $products = Product::all();
        return view('admin.stock.index', compact('stocks', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $request->validate([
            'product_id'  =>  'required||exists:products,id',
            'status'  =>  'required|in:in,out',
            'amount'  =>  'required|numeric',
            'desc'  =>  'nullable',
        ]);

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

        return redirect()->route('members.index');
    }

    public function report()
    {
        $products = Product::with('stocked')->orderBy('name', 'asc')->get();
        
        foreach ($products as $p) {
            $p['add'] = 0;
            $p['min'] = 0;
            $p['total'] = 0;
            
            foreach ($p->stocked as $s) {
                $p['add'] += $s->increase;
                $p['min'] += $s->decrease;
                $p['add'] = $p['add'];
                $p['min'] = $p['min'];
            }

            $p['total'] = $p['stock'] + $p['add'] - $p['min'];
        }
        
        return view('admin.stock.report', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}

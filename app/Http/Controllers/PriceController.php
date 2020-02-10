<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;
use App\Product;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Price $price)
    {
        $prices = Price::with('product')->get();
        // return response()->json($prices);
        $products = Product::all();
        return view('admin.price.index', compact('prices', 'products'));
    }

    // function rupiah ($angka) {
    //     $hasil = 'Rp ' . number_format($angka, 2, ",", ".");
    //     return $hasil;
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'product_id' => 'required',
            'amount' => 'required'
        ]);

        $price = Price::create($request->all());

        return redirect()->route('prices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'product_id'  =>  'required',
            'amount'  =>  'required'
        ]);

        $data = [
            'product_id' => $request->product_id,
            'amount' => $request->amount,
        ];

        $price = Price::findOrFail($id);
        $price->update($data);

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $price = Price::findOrFail($id);
        $price->delete();

        return redirect(route('prices.index'));
    }
}

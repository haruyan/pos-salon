<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\{Transactions, Member, MemberCategory, Product, Stock};

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trxs = Transactions::with('cashierDesc', 'buyerDesc.membcat')->orderBy('created_at', 'desc')->get();
        $income = 0;
        foreach ($trxs as $t => $trx) {
          $income += $trx->total;
        }

        return view('admin.transactions.index', compact('trxs', 'income'));
    }

    public function memberIndex()
    {
        $members = Member::orderBy('full_name', 'asc')->get();
        return view('admin.transactions_member.index', compact('members'));
    }

    public function memberShow($id)
    {
        $member = Member::where('id', $id)->with('membcat')->get()->first();
        $trxs = Transactions::where('buyer', $id)->with('cashierDesc')->orderBy('created_at', 'desc')->get();
        $data =[];
        $results = [];

        foreach ($trxs as $t => $trx) {
          $trx->item = json_decode($trx->item);
          array_push($data, $trx->item);
        }

        $collect0 = collect($data)->flatten(1)->groupBy('productId')->toArray();
        foreach ($collect0 as $collect1) {
          $productSum = 0;
          foreach ($collect1 as $collect2) {
            $productSum += $collect2->quantity;
            $collect2->sum = $productSum;
          }
          $last = end($collect1);
          array_push($results, $last);
        }
        usort($results, function ($item1, $item2) {
          return $item1->nama_barang <=> $item2->nama_barang;
        });
        
        return view('admin.transactions_member.details', compact('member', 'trxs', 'results'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $data = Transactions::find($id);
      $data->item = json_decode($data->item);

      //get item id stock/remain
      $items = $data->item;//json_decode($request->item);
      $change = 0;
      $dataStock = [];
      foreach($items as $item){
          $init = Product::where('id', $item->productId)->get()->first();
          $latest = Stock::where('product_id', $item->productId)->get()->last();
          
          //check if there's any product data in stock
          if($latest)
            $change = $latest->remain + $item->quantity;
          else
            $change = $init->stock + $item->quantity;
          
          $stock = [
            'product_id' => $item->productId,
            'trx_id' => $data->trx_number,
            'increase' => $item->quantity,
            'decrease' => 0,
            'remain' => $change,
            'status' => 'delete_trx',
            'desc' => 'menghapus trx',
            'created_at' => Carbon::now()->toDateTimeString(),
          ];
          array_push($dataStock, $stock);
          
      }
      Stock::insert($dataStock);
      
      $data->delete();
      return redirect(route('transactions.index'));
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
    public function exstore(Request $request)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function xupdate(Request $request, Transactions $transactions, $id)
    {
      //
    }

}

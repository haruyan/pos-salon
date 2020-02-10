<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\{Transactions, Product, Stock, Member};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{Auth, Validator};

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
      
        if ($limit == -1) {
            $trx = Transactions::with('cashierDesc', 'buyerDesc.membcat')->orderBy('created_at', 'desc')->get();
        } else {
            $trx = Transactions::with('cashierDesc', 'buyerDesc.membcat')
                                ->limit($limit)
                                ->offset($offset)
                                ->orderBy('created_at', 'desc')
                                ->get();
        }

        foreach ($trx as $t) {
            $t->item = json_decode($t->item);
        }
      
        return response()->json($trx);
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
            'buyer' => 'nullable',
            'promo' => 'nullable',
            'item' => 'required',
            'total' => 'required',
        ]);
      
        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }
      
      
        //trx number generator
        $rmdash = str_replace("-","",Carbon::now()->toDateTimeString());
        $rmcolon = str_replace(":","",$rmdash);
        $rmspace = str_replace(" ","",$rmcolon).substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,3);
        $trx_number = 'TRX'.$rmspace;
        
     
        //get item id stock/remain
        $items = $request->item;//json_decode($request->item);
        $change = 0;
      
        $dataStock = [];
        foreach($items as $item){
            $init = Product::where('id', $item['productId'])->get()->first();
            $latest = Stock::where('product_id', $item['productId'])->get()->last();
            
            //check if there's any product data in stock
            if($latest)
              $change = $latest->remain - $item['quantity'];
            else
              $change = $init->stock - $item['quantity'];
            
            $stock = [
              'product_id' => $item['productId'],
              'trx_id' => $trx_number,
              'increase' => 0,
              'decrease' => $item['quantity'],
              'remain' => $change,
              'status' => 'trx',
              'desc' => 'penjualan',
              'created_at' => Carbon::now()->toDateTimeString(),
            ];
            array_push($dataStock, $stock);
            
        }
        Stock::insert($dataStock);
        $buyer = (!$request->buyer) ?  0 : $request->buyer;
      
        $dataDetails = (object) array(
          'buyer' => $buyer,
          'promo' => $request->promo,
          'persen_discount' => $request->persen_disc,
          'price_before' => $request->price_before_disc,
          'total_potongan' => $request->total_discount,
          'price_after' => $request->total,
        );

        $transaction = new Transactions;
        $transaction->cashier = Auth::user()->id;
        $transaction->promo = $request->promo;
        $transaction->trx_number = $trx_number;
        $transaction->buyer = $buyer;
        $transaction->details = json_encode($dataDetails);
        $transaction->item = json_encode($request->item);
        $transaction->total = $request->total;
        $transaction->save();
      
        $transaction->item = json_decode($transaction->item);
        $success['status'] = 'success';
        $success['data_transaction'] = $transaction;
        $success['data_stock'] = $dataStock;

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
        $trx = Transactions::where('id',$id)->with('cashierDesc', 'buyerDesc.membcat')->get()->first();
        $item = json_decode($trx->item);
        $detail = json_decode($trx->details);

        $arr = [];
        $total = [
          'harga' => $detail->price_before,
          'diskon' => $detail->total_potongan,
          'bayar' => $detail->price_after
        ];
        foreach ($item as $i) {
            $product = Product::where('id', $i->productId)->get()->first();
          
            $potongan = 0;
            if ($i->potongan_persen == 0) {
                if($i->potongan_amount >0) $potongan = $i->potongan_amount;
            } else {
                $potongan = $i->sub_total * $i->potongan_persen / 100;
            }
          
            $list = [
                'product' => $product['name'],
                'priceInit' => $i->item_price,
                'quantity' => $i->quantity,
                'priceSum' => $i->sub_total,
                'potongan' => $potongan,
            ];
            array_push($arr, $list);
        }
      
        $obj = (object) Array(
            'trx' => $trx,
            'item' => $arr,
            'total' => $total
        );

        $trx->item = json_decode($trx->item);
        $trx->details = json_decode($trx->details);
        return response()->json($obj);
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

    public function search(Request $request)
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
        
        $day0 = date('Y-m-d 00:00:00'); #set today start
        $day1 = date('Y-m-d 23:59:59'); #set today end

        $dayStart = date($request->start. ' 00:00:00');
        $dayEnd = date($request->end. ' 23:59:59');

        (!$request->start) ? $from = $day0 : $from = $dayStart;
        (!$request->end) ? $to = $day1 : $to = $dayEnd;

        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
      
        if ($limit == -1) {
            $trx = Transactions::with('cashierDesc', 'buyerDesc.membcat')
                                ->orderBy('created_at', 'desc')
                                ->whereBetween('created_at',[$from, $to])
                                ->get();
        } else {
            $trx = Transactions::with('cashierDesc', 'buyerDesc.membcat')
                                ->orderBy('created_at', 'desc')
                                ->whereBetween('created_at',[$from, $to])
                                ->limit($limit)
                                ->offset($offset)
                                ->get();
        }

        foreach ($trx as $t) {
            $t->item = json_decode($t->item);
        }

        $success['status'] = 'success';
        $success['data'] = $trx;
        return response()->json($success);
    }
  
    public function cashier(Request $request, $id)
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
        
//         $day0 = date('2000-m-d 00:00:00'); #set today start
//         $day1 = date('Y-m-d 23:59:59'); #set today end
        $day0 = date('Y-m-d 00:00:00'); #set today start
        $day1 = date('Y-m-d 23:59:59'); #set today end

        $dayStart = date($request->start. ' 00:00:00');
        $dayEnd = date($request->end. ' 23:59:59');

        (!$request->start) ? $from = $day0 : $from = $dayStart;
        (!$request->end) ? $to = $day1 : $to = $dayEnd;

//         return      response()->json([$from, $to]);
      
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
      
        if ($limit == -1) {
            $trx = Transactions::with('cashierDesc', 'buyerDesc.membcat')
                                ->where('cashier', $id)
                                ->whereBetween('created_at',[$from, $to])
                                ->orderBy('created_at','desc')
                                ->get();
        } else {
            $trx = Transactions::with('cashierDesc', 'buyerDesc.membcat')
                                ->where('cashier', $id)
                                ->whereBetween('created_at',[$from, $to])
                                ->orderBy('created_at','desc')
                                ->limit($limit)
                                ->offset($offset)
                                ->get();
        }

        foreach ($trx as $t) {
            $t->item = json_decode($t->item);
        }

        $success['status'] = 'success';
        $success['data'] = $trx;
        return response()->json($success);
    }

    public function member($id)
    {
        $member = Member::where('id', $id)->with('membcat')->get()->first();
        $trxs = Transactions::where('buyer', $id)->with('cashierDesc')->orderBy('created_at', 'desc')->get();
        $data =[];
        $results = [];

        foreach ($trxs as $t => $trx) {
          $trx->item = json_decode($trx->item);
          $trx->details = json_decode($trx->details);
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


        $success['status'] = 'success';
        $success['data'] = [
            'detailMember' => $member,
            'detailTrx' => $trxs,
            'detailProduct' => $results
        ];
        return response()->json($success);
    }

    public function filter(Request $request)
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

        $trx = Transactions::with('cashierDesc', 'buyerDesc.membcat')->whereBetween('created_at',[$from, $to])->get();
        $data = [];
        $income = 0;

        foreach ($trx as $index => $t) {
            $t->buyerDesc == null ? $buyer = "UMUM" : $buyer = strtoupper($t->buyerDesc->full_name);
            $total = 'Rp '.number_format($t->total,2,',','.');
            $action = route('transactions.destroy', $t->id);
            $push = [
                '0' => $index+1,
                '1' => $t->trx_number,
                '2' => $t->cashierDesc->full_name,
                '3' => $buyer,
                '4' => $total,
                '5' => date($t->created_at),
                '6' =>  '<form action="'.$action.'" method="post" id="swal-datatable-'.$t->id.'" class="formToken">
                            <input type="hidden" name="_token" value="'.$request->csrf.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" onclick="showThis('.$t->id.')">
                                <i class="material-icons">launch</i>
                            </button>
                            <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis('.$t->id.')">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>',
            ];
            array_push($data, $push);

            $income += $t->total;
        }

        $thisData['table'] = $data;
        $thisData['info'] = [
            'income' => $income,
            'count' => count($trx)
        ];
        
        return response()->json($thisData);
    }
}

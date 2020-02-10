<?php

namespace App\Http\Controllers\API;

use App\MemberCategory;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class ProductController extends Controller
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
            $products = Product::with('category')->get();
            
        } else {
            $products = Product::with('category')
                                ->limit($limit)
                                ->offset($offset)
                                ->get();
        }
      
        $memberCategories = MemberCategory::all();
        foreach ($products as $p){
          $p->prices = json_decode($p->prices);
          
          $prices = array();//$p->prices;
          
          $list_cat_member_id = Arr::pluck($p->prices, 'cat_member_id');
          foreach($memberCategories as $m){
            if(in_array($m->id, $list_cat_member_id)){
              $key = array_search($m->id,$list_cat_member_id);
              $data= (object) array(
                'cat_member_id' => strval($m->id),
                'price' =>   $p->prices[$key]->price,//$p->prices[$key],
              );
              array_push($prices, $data);
            }
            else{
              $data= (object) array(
                'cat_member_id' => strval($m->id),
                'price' => "0",
              );
              array_push($prices, $data);
            }
          }
          $p->prices = $prices;
          $stock = $p->getLastStock($p->id);
          $p->stock = $stock!=null ? $stock : $p->stock;
        }

      
        return response()->json($products);
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
            'name'                  =>  'required',
            'desc'                  =>  'required',
            'stock'                 =>  'required|integer',
            'prices'                =>  'required',
            'product_category_id'   =>  'required|exists:product_categories,id',
            'image'                 =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }
      
        $fileName = str_replace("=","",base64_encode($request->name.time())) . '.' . request()->image->getClientOriginalExtension();

        if(!$request->image->move(storage_path('app/public/product'), $fileName)){
            return array('error' => 'Gagal upload foto');
        } else {
            $product = new Product();
            $product->name = $request->name;
            $product->desc = $request->desc;
            $product->stock = $request->stock;
            $product->product_category_id = $request->product_category_id;
            $product->image = "storage/product/".$fileName;
            $product->prices = $request->prices;
            $product->save();
        }

        $success['status'] = 'success';
        $success['data'] = $product;
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
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function productPrice(Request $request)
    {
        $products = Product::whereIn('id', $request->id)->get();
        $prices = [];
        $listPrice = [];
        $memberCategories = MemberCategory::all();
        foreach($products as $p){
            $p->prices = json_decode($p->prices);
            
            $prices_temp = array();//$p->prices;
          
            $list_cat_member_id = Arr::pluck($p->prices, 'cat_member_id');
            foreach($memberCategories as $m){
                if(in_array($m->id, $list_cat_member_id)){
                $key = array_search($m->id,$list_cat_member_id);
                $data= (object) array(
                  'cat_member_id' => strval($m->id),
                  'price' =>   $p->prices[$key]->price,//$p->prices[$key],
                );
                array_push($prices_temp, $data);
              }
              else{
                $data= (object) array(
                  'cat_member_id' => strval($m->id),
                  'price' => "0",
                );
                array_push($prices_temp, $data);
              }
            }

            $listPrice = array(
                'id_product' => $p->id,
                'nama_product' => $p->name,
                'prices' => $prices_temp
            );
            array_push($prices, $listPrice);
        }

        return response()->json($prices);
    }

    public function search(Request $request)
    {
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;

        // query builder
        if ($limit == -1) {
            $products = Product::with('category');
        } else {
            $products = Product::with('category')
                                ->limit($limit)
                                ->offset($offset);
        }

        // by keyword
        $keyword = $request->keyword;
        if($keyword) {
            $products->where('name',"like",'%' . $keyword . '%');
        }

        // by category
        $category = $request->category;
        if($category) {
            $products->where('product_category_id',$category);
        }

        // order parameter
        $orderField = $request->orderBy;
        $orderDirection = $request->direction ?? 'ASC';

        if($orderField) {
            $products->orderBy($orderField, $orderDirection);
        }

        $products = $products->get();
        $memberCategories = MemberCategory::all();
      
        foreach ($products as $p){
          $p->prices = json_decode($p->prices);
           
          $prices = array();//$p->prices;
          
          $list_cat_member_id = Arr::pluck($p->prices, 'cat_member_id');
          foreach($memberCategories as $m){
            if(in_array($m->id, $list_cat_member_id)){
              $key = array_search($m->id,$list_cat_member_id);
              $data= (object) array(
                'cat_member_id' => $m->id,
                'price' =>   $p->prices[$key]->price,//$p->prices[$key],
              );
              array_push($prices, $data);
            }
            else{
              $data= (object) array(
                'cat_member_id' => $m->id,
                'price' => 0,
              );
              array_push($prices, $data);
            }
          }
          $p->prices = $prices;
          $stock = $p->getLastStock($p->id);
          $p->stock = $stock!=null ? $stock : $p->stock;
        }
        return response()->json($products);
    }


}

<?php

namespace App\Http\Controllers;
use App\MemberCategory;
use App\Product;
use App\Product_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membersCat = MemberCategory::pluck('name','id')->toArray();
        $memberCategories = MemberCategory::all();
        $category = Product_categories::all();
        $products = Product::with("category")->orderBy('name','asc')->get();
        $datareturnMerge = array();
        foreach($products as $p){
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
          
         
          $data = (object) array(
                'data' => $p,
                'merge_prices' => $prices
          );
           
          array_push($datareturnMerge, $data);
        }
//       return dd($datareturnMerge);
        return view('admin.products.index', compact('products','category', 'membersCat', 'memberCategories', 'datareturnMerge'));

    }

    public function indexCategorized($id)
    {
        $membersCat = MemberCategory::pluck('name','id')->toArray();
        $memberCategories = MemberCategory::all();
        $category = Product_categories::all();
        $products = Product::where('product_category_id', $id)->with("category")->orderBy('name','asc')->get();
        $datareturnMerge = array();
        foreach($products as $p){
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
          
         
          $data = (object) array(
                'data' => $p,
                'merge_prices' => $prices
          );
           
          array_push($datareturnMerge, $data);
        }
//       return dd($datareturnMerge);
        return view('admin.products.index', compact('products','category', 'membersCat', 'memberCategories', 'datareturnMerge'));

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
            'name'                  =>  'required',
            'desc'                  =>  'required',
            'stock'                 =>  'required|integer',
            'prices.*'              =>  'min:3',
            'id_cat_members.*'      =>  'required',
            'product_category_id'   =>  'required',
            'type'                  =>  'required|in:product,service',
            'image'                 =>  'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $arr = [];
        foreach ($request->id_cat_members as $c => $catMember){
            $price = [
                'cat_member_id' => $catMember,
                'price' => $request->prices[$c],
            ];
            array_push($arr, $price);
        }
        // $fileName = str_replace("=","",base64_encode($request->name.time())) . '.' . request()->image->getClientOriginalExtension();

        // if(!$request->image->move(storage_path('app/public/product'), $fileName)){
        //     return array('error' => 'Gagal upload foto');
        // } else {
            $product = new Product();
            $product->name = $request->name;
            $product->desc = $request->desc;
            $product->type = $request->type;
            $request->type == 'service' ? $product->stock = 0 : $product->stock = $request->stock;
            $product->product_category_id = $request->product_category_id;
            $product->image = str_replace(url('').'/', '', $request->image); // "storage/product/".$fileName;
            $product->prices = json_encode($arr);
            $product->save();
        // }

        return response()->json($product);
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

    public function update(Request $request, $id)
    {
        // $productPict = Product::where("id","=",$id)->get()->first()->image;
        // // return response()->json($productPict);
        // if (!$request->image) {
        //     // return 'still';
        //     $request->validate([
        //         'name'                  => 'required',
        //         'desc'                  => 'required',
        //         'stock'                 => 'required|integer',
        //         'prices.*'              => 'integer|min:3',
        //         'id_cat_members.*'      => 'required',
        //         'product_category_id'   => 'required',
        //         'type2'                  => 'required|in:product,service',
        //     ]);
        // } else {
            // return 'changed';
            $request->validate([
                'name'                  => 'required',
                'desc'                  => 'required',
                'stock'                 => 'required|integer',
                'prices.*'              => 'integer|min:3',
                'id_cat_members.*'      => 'required',
                'product_category_id'   => 'required',
                'type2'                  => 'required|in:product,service',
                'image'                 => 'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        //     $fileName = str_replace("=","",base64_encode($request->name.time())) . '.' . request()->image->getClientOriginalExtension();
        // }

        $arr = [];
        foreach ($request->id_cat_members as $c => $catMember){
            $price = [
                'cat_member_id' => $catMember,
                'price' => $request->prices[$c],
            ];
            array_push($arr, $price);
        }


        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->desc = $request->desc;
        $product->type = $request->type2;
        $request->type2 == 'service' ? $product->stock = 0 : $product->stock = $request->stock;
        $product->product_category_id  = $request->product_category_id;
        $product->prices = json_encode($arr);
        $product->image = str_replace(url('').'/', '', $request->image);
        // if($request->hasFile('image')){
        //     // return 'has file';
        //     if (is_file($product->image)) {
        //         try {
        //             unlink($productPict);
        //         } catch(\Exception $e) {

        //         }
        //     }
        //     $request->image->move(storage_path('app/public/product'), $fileName);
        //     $product->image = "storage/product/".$fileName;
        // }else {
        //     // return 'kosong';
        //     $product->image = $productPict;
        // }
        $product->update();

        return 'success';
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // if (is_file($product->image)) {
        //     unlink($product->image);
        // }
        $product->delete();
        return redirect(route('products.index'));
    }

    public function getProductByCategory($category)
    {
        $product = Product::where('product_category_id',$category)->get();
        return response()->json($product);
    }

}

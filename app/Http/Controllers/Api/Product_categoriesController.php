<?php

namespace App\Http\Controllers\API;

use App\Product_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Product_categoriesController extends Controller
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
            $productCategories = Product_categories::all();
        } else {
            $productCategories = Product_categories::limit($limit)
                                ->offset($offset)
                                ->get();
        }

        return response()->json($productCategories);
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
            'name'  =>  'required',
            'desc'  =>  'required',
            'image'  =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }
        $fileName = str_replace("=","",base64_encode($request->username.time())) . '.' . request()->image->getClientOriginalExtension();

        if(!$request->image->move(storage_path('app/public/product_categories'), $fileName)){
            return array('error' => 'Gagal upload foto');
        } else {
            $product_categories = new product_categories();
            $product_categories->name = $request->name;
            $product_categories->desc = $request->desc;
            $product_categories->image = "storage/product_categories/".$fileName;
            $product_categories->save();
        }

        $success['status'] = 'success';
        $success['data'] = $product_categories;
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
        $product_categories = Product_categories::findOrFail($id);
        return response()->json($product_categories);
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
        $product_categoriesPict = Product_categories::where("id","=",$id)->get()->first()->image;
        if (!$request->image) {
            $validator = Validator::make($request->all(),[
                'name'  =>  'required',
                'desc'  =>  'required',
            ]);
        } else {
            $validator = Validator::make($request->all(),[
                'name'  =>  'required',
                'desc'  =>  'required',
                'image'  =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fileName = str_replace("=","",base64_encode($request->name.time())) . '.' . request()->image->getClientOriginalExtension();
        }

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }

        $product_categories = Product_categories::findOrFail($id);
        $product_categories->name = $request->name;
        $product_categories->desc  = $request->desc;
        if($request->hasFile('image')){
            // return 'available file';
            if (is_file($product_categories->image)) {
                try {
                    unlink($product_categoriesPict);
                } catch(\Exception $e) {

                }
            }
            $request->image->move(storage_path('app/public/product_categories'), $fileName);
            $product_categories->image = "storage/product_categories/".$fileName;
            // return response()->json($product_categories->image);
        }else {
            // return 'no file uploaded';
            $product_categories->image = $product_categoriesPict;
        }
        $product_categories->save();

        $success['status'] = 'success';
        $success['data'] = $product_categories;
        return response()->json($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_categories = Product_categories::findOrFail($id);
        if (is_file($product_categories->image)) {
            unlink($product_categories->image
        );
        }
        $product_categories->delete();
        $success['status'] = 'success deleted';
        $success['data'] = $product_categories;
        return response()->json($success);
    }

    public function search(Request $request)
    {
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;

        // query builder
        if ($limit == -1) {
            $productCategories =  DB::table('product_categories');
        } else {
            $productCategories = Product_categories::limit($limit)
                                ->offset($offset);
        }

        //# by keyword parameter keyword
        $keyword = $request->keyword;
        if($keyword) {
            $productCategories->where('name',"like",'%' . $keyword . '%');
        }

        //# order parameter orderBy & direction
        $orderField = $request->orderBy;
        $orderDirection = $request->direction ?? 'ASC';

        if($orderField) {
            $productCategories->orderBy($orderField, $orderDirection);
        }

        $productCategories = $productCategories->get();
        return response()->json($productCategories);
    }
}

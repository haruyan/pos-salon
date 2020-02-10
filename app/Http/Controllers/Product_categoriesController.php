<?php

namespace App\Http\Controllers;

use App\Product_categories;
use Illuminate\Http\Request;


class Product_categoriesController extends Controller
{
    public function index()
    {
        $product_categories = Product_categories::all();
        return view('admin.product_categories.index', compact('product_categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'  =>  'required',
            'desc'  =>  'required',
            'image'  =>  'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // $fileName = str_replace("=","",base64_encode($request->username.time())) . '.' . request()->image->getClientOriginalExtension();

        // if(!$request->image->move(storage_path('app/public/product_categories'), $fileName)){
        //     return array('error' => 'Gagal upload foto');
        // } else {
            $product_categories = new product_categories();
            $product_categories->name = $request->name;
            $product_categories->desc = $request->desc;
            $product_categories->image = str_replace(url('').'/', '', $request->image);//"storage/product_categories/".$fileName;
            $product_categories->save();
        // }

        return redirect()->route('product_categories.index');
    }
    public function update(Request $request, $id)
    {
        // $product_categoriesPict = Product_categories::where("id","=",$id)->get()->first()->image;
        // // return response()->json($request);
        // if (!$request->image) {
        //     // return 'still';
        //     $request->validate([
        //         'name'  =>  'required',
        //         'desc' => 'required',
              
        //     ]);
        // } else {
            // return 'changed';
            $request->validate([
                'name'  =>  'required',
                'desc'  =>  'required',
                'image'  =>  'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        //     $fileName = str_replace("=","",base64_encode($request->name.time())) . '.' . request()->image->getClientOriginalExtension();
        // }

        $product_categories = Product_categories::findOrFail($id);
        $product_categories->name = $request->name;
        $product_categories->desc = $request->desc;
        $product_categories->image = str_replace(url('').'/', '', $request->image);
        // if($request->hasFile('image')){
        //     // return 'available file';
        //     if (is_file($product_categories->image)) {
        //         try {
        //             unlink($product_categoriesPict);
        //         } catch(\Exception $e) {

        //         }
        //     }
        //     $request->image->move(storage_path('app/public/product_categories'), $fileName);
        //     $product_categories->image = "storage/product_categories/".$fileName;
        //     // return response()->json($product_categories->image);
        // }else {
        //     // return 'no file uploaded';
        //     $product_categories->image = $product_categoriesPict;
        // }
        $product_categories->update();

        return 'success';
    }
    public function destroy($id)
    {
        $product_categories = Product_categories::findOrFail($id);
        // if (is_file($product_categories->image)) {
        //     unlink($product_categories->image
        // );
        // }
        $product_categories->delete();
        return redirect(route('product_categories.index'));
    }

}

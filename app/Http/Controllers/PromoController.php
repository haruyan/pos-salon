<?php

namespace App\Http\Controllers;
use App\Promo;
use App\CodePromo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $codepromo = CodePromo::all();
        $promos = Promo::with('codePromo')->get();
        return view('admin.promos.index', compact('promos','codepromo'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  =>  'required',
            'desc'  =>  'required',
            'code_promo_id'  =>  'required',
            'image'  =>  'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->has('active')) {
           $active = 1;
        } else {
            $active = 0;
        }

        // $fileName = str_replace("=","",base64_encode($request->name.time())) . '.' . request()->image->getClientOriginalExtension();

        // if(!$request->image->move(storage_path('app/public/promo'), $fileName)){
        //     return array('error' => 'Gagal upload foto');
        // } else {
            $promo = new Promo();
            $promo->name = $request->name;
            $promo->desc = $request->desc;
            $promo->active = $active;
            $promo->code_promo_id = $request->code_promo_id;
            $promo->image = str_replace(url('').'/', '', $request->image); //"storage/promo/".$fileName;;
            $promo->save();
        // }

        return redirect()->route('promos.index');
    }

    public function update(Request $request, $id)
    {
        // $promoPict = Promo::where("id","=",$id)->get()->first()->image;
        // // return response()->json($productPict);
        // if (!$request->image) {
        //     // return 'still';
        //     $request->validate([
        //         'name'  =>  'required',
        //         'code_promo_id'  =>  'required',
        //         'desc'  =>  'required',
        //     ]);
        // } else {
            // return 'changed';
            $request->validate([
                'name'  =>  'required',
                'code_promo_id'  =>  'required',
                'desc'  =>  'required',
                'image'  =>  'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        //     $fileName = str_replace("=","",base64_encode($request->name.time())) . '.' . request()->image->getClientOriginalExtension();
        // }

        if ($request->has('active')) {
            $active = 1;
         } else {
             $active = 0;
         }

        $promo = Promo::findOrFail($id);
        $promo->name = $request->name;
        $promo->active  = $active;
        $promo->desc = $request->desc;
        $promo->code_promo_id = $request->code_promo_id;
        $promo->image = str_replace(url('').'/', '', $request->image);
        // if($request->hasFile('image')){
        //     // return 'has file';
        //     if (is_file($promo->image)) {
        //         try {
        //             unlink($promoPict);
        //         } catch(\Exception $e) {

        //         }
        //     }
        //     $request->image->move(storage_path('app/public/promo'), $fileName);
        //     $promo->image = "storage/promo/".$fileName;
        // }else {
        //     // return 'kosong';
        //     $promo->image = $promoPict;
        // }
        $promo->update();

        return 'success';
    }
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        // if (is_file($promo->image)) {
        //     unlink($promo->image);
        // }
        $promo->delete();
        return redirect(route('promos.index'));
    }
}


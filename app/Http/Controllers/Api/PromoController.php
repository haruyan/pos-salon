<?php

namespace App\Http\Controllers\API;
use App\Promo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoController extends Controller
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

        // query builder
        $promos = Promo::limit($limit)
                            ->offset($offset)
                            ->where('active', '1');

        // by keyword
        // $keyword = $request->keyword;
        // if($keyword) {
        //     $promos->where('name',"like",'%' . $keyword . '%');
        // }
//         return response()->json(in_array($request->direction, ['asc','desc']) ? $request->direction:'asc');
        // order parameter

        $orderField = in_array($request->orderBy,['id','name']) ? $request->orderBy : 'id';
        $orderDirection = in_array($request->direction, ['asc','desc']) ? $request->direction:'asc';

        if($orderField) {
            $promos->orderBy($orderField, $orderDirection);
        }

        $promos = $promos->get();
        
        foreach ($promos as $p) {
            $p['code_promo'] = $p->getCodeDetails($p->code_promo_id);
        }
        
        return response()->json($promos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promos = Promo::findOrFail($id);
        return response()->json($promos);
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

    public function detailByCode($promoCode)
    {
        $promo = Promo::whereHas('codePromo',function($query) use($promoCode) {
                            $query->where('code',$promoCode);
                        })->get()->first();
        // foreach ($promos as $p) {
      if($promo != null)
        $promo['code_promo1'] = $promo->getCodeDetails($promo->code_promo_id);
        // }
        
        return response()->json($promo);
    }

    public function search(Request $request)
    {
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;

        // query builder
        $promos = Promo::with('category')
                            ->limit($limit)
                            ->offset($offset);

        // by keyword
        // $keyword = $request->keyword;
        // if($keyword) {
        //     $promos->where('name',"like",'%' . $keyword . '%');
        // }

        // order parameter
        $orderField = in_array($request->orderBy,['id','name']) ? $request->orderBy : 'id';
        $orderDirection = in_array($request->direction, ['asc','desc']) ? $request->direction:'asc';

        if($orderField) {
            $promos->orderBy($orderField, $orderDirection);
        }

        $promos = $promos->get();
        return response()->json($promos);
    }
}

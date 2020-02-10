<?php

namespace App\Http\Controllers;
use App\CodePromo;
use Illuminate\Http\Request;
use App\Product_categories;
use App\Product;

class CodePromoController extends Controller
{
      public function index()
      {
        $codepromo =    CodePromo::all();
        $productCategories = Product_categories::all();
        return view('admin.code_promo.index', compact('codepromo','productCategories'));
      }

      public function store(Request $request)
      {
        $request->validate([
          'promoCode' =>  'required|unique:code_promo,code',
          'startDate' => 'required',
          'endDate' => 'required',
          'discount' => 'required',
          'amount'  =>  'required',
          'minimum' => 'required',
          'discountType'  => 'required',
          'isAllProduct'  => 'required'
        ]);

        // transform category rules
        $selectedCategories = collect($request->selectedCategories);
        $selectedCategories->transform(function($category) use($request) {
          
          $productIds = isset($request->productByCategory[$category]) ? $request->productByCategory[$category] : [];
          return [
            "catId"         => $category,
            "isAllProduct"  => $request->categorySetting[$category],
            "productIds"    => $productIds
          ];
        });

          // recap all rules
          $rule = [
            'totalBeli'         => $request->totalBeli,
            'allProduct'        => $request->isAllProduct,
            'discountType'      => $request->discountType,
            'categorySetting'   => $selectedCategories
          ];

          $codepromo  = new CodePromo();
          $codepromo->code = $request->promoCode;
          $codepromo->start = date('Y-m-d',strtotime($request->startDate));
          $codepromo->end = date('Y-m-d',strtotime($request->endDate));
          $codepromo->amount = $request->amount;
          $codepromo->discount = $request->discount;
          $codepromo->minimum = $request->minimum;
          $codepromo->rule = json_encode($rule);
          $codepromo->save();

          return response()->json($codepromo);
      }

      public function update(Request $request, $id)
      {
        $request->validate([
          'promoCode'     => 'required|unique:code_promo,code,'.$id,
          'startDate'     => 'required',
          'endDate'       => 'required',
          'discount'      => 'required',
          'amount'        => 'required',
          'minimum'       => 'required',
          'discountType'  => 'required',
          'isAllProduct'  => 'required'
        ]);

        // transform category rules
        $selectedCategories = collect($request->selectedCategories);
        $selectedCategories->transform(function($category) use($request) {
          
          $productIds = isset($request->productByCategory[$category]) ? $request->productByCategory[$category] : [];
          return [
            "catId"         => $category,
            "isAllProduct"  => $request->categorySetting[$category],
            "productIds"    => $productIds
          ];
        });

          // recap all rules
          $rule = [
            'totalBeli'         => $request->totalBeli,
            'allProduct'        => $request->isAllProduct,
            'discountType'      => $request->discountType,
            'categorySetting'   => $selectedCategories
          ];

          $codepromo  = CodePromo::findOrFail($id);
          $codepromo->code = $request->promoCode;
          $codepromo->start = date('Y-m-d',strtotime($request->startDate));
          $codepromo->end = date('Y-m-d',strtotime($request->endDate));
          $codepromo->amount = $request->amount;
          $codepromo->discount = $request->discount;
          $codepromo->minimum = $request->minimum;
          $codepromo->rule = json_encode($rule);
          $codepromo->save();

          return response()->json($codepromo);
      }

      public function destroy($id)
      {
          $codepromo = CodePromo::findOrFail($id);
          $codepromo->delete();
          return redirect(route('codepromo.index'));
      }

      public function show($idPromo)
      {
        $codepromo = CodePromo::findOrFail($idPromo);
        return response()->json($codepromo);
      }
}


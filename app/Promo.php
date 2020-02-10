<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    protected $guarded = ['id'];

    public function codePromo(){
        return $this->belongsTo(CodePromo::class,'code_promo_id', 'id');
    }

    public function getCodeDetails($id){
        $codeDetails = $this->codePromo()->where('id', $id)->get()->first();
//       dd($codeDetails);
        if($codeDetails != null){
           $codeDetails->rule = json_decode($codeDetails->rule);

          if(sizeof($codeDetails->rule->categorySetting)>0){
            $getProductId = $codeDetails->rule->categorySetting[0]->productIds;
            $productArray = [];
            
            
            foreach($getProductId as $p){
              if($p !=null) array_push($productArray, $p->id);
            }

            $codeDetails->rule->categorySetting[0]->productIds = $productArray;
          }
        }
       
        
        // return response()->json($getProductId);
        return $codeDetails;
    }
}

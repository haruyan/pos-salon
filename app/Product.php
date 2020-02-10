<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(Product_categories::class,'product_category_id','id');
    }

    // perubahan stock (trx, deleted trx, in, out, etc..)
    public function stocked(){
        return $this->hasMany('App\Stock');
    }

    public function getLastStock($id)
    {
        $stocks = $this->stocked()->where('product_id',$id)->get()->last();
        return $stocks['remain'];
    }
  
    public function getStockBeforeDate($date)
    {
        $stocks = $this->stocked()->where('created_at','<',$date)->get()->last();
        return $stocks['remain'];
    }

    public function getStockOnRange($start, $end)
    {
        $stocks = $this->stocked()->whereBetween('created_at',[$start, $end])->get();
        $changes = [
            'add' => 0,
            'min' => 0,
            'sold' => 0,
            'deleted' => 0,
        ];
        foreach ($stocks as $s => $stock) {
            // report stock
            $changes['add'] += $stock->increase;
            $changes['min'] += $stock->decrease;
        }
        return $changes;
    }

}

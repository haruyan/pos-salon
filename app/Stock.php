<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $guarded = ['id'];
    
    public function details(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}

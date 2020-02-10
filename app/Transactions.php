<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $guarded = ['id'];

    public function cashierDesc() {
        return $this->belongsTo(User::class, "cashier");
    }
    public function buyerDesc() {
        return $this->belongsTo(Member::class, "buyer");
    }
}

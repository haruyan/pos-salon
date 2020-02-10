<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $guarded = ['id'];

    public function membcat(){
        return $this->belongsTo(MemberCategory::class,'member_category_id','id');
    }

    public function expiredOn()
    {
    	return Carbon::now()->diffInDays($this->expired, false);
    }
}

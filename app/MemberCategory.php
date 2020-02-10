<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberCategory extends Model
{
    protected $table = 'member_categories';
    protected $guarded = ['id'];
}

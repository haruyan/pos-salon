<?php

use App\MemberCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MemberCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        	[
        		"id"=>1,
        		"name"=>'silver',
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
        	],[
        		"id"=>2,
        		"name"=>'gold',
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
            ]
        ];

    	MemberCategory::insert($data);
    }
}

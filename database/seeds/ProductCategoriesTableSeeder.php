<?php

use App\Product_categories;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
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
                "name"=>"perawatan wajah",
                "image"=>"",
                "desc"=>"sample first category for product",
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
        	],[
        		"id"=>2,
                "name"=>"perawatan tubuh",
                "image"=>"",
                "desc"=>"sample second category for product",
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
            ]
        ];

    	Product_categories::insert($data);
    }
}

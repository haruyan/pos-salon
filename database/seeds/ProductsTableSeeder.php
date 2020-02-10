<?php

use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
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
                "name"=>"sabun wajah",
                "image"=>"",
        		"product_category_id"=>1,
                "desc"=>"sample first product",
                "prices"=>"",
                "stock"=>100,
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
        	],[
                "name"=>"sabun badan",
                "image"=>"",
        		"product_category_id"=>2,
                "desc"=>"sample second product",
                "prices"=>"",
                "stock"=>80,
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
            ]
        ];

    	Product::insert($data);
    }
}

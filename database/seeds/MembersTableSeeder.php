<?php

use App\Member;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
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
                "date_of_birth" => "1943-08-21",
                "gender" => "wanita",
                "full_name" => "hayatii",
                "member_category_id" => 1,
                "phone" => "873568837s6",
                "address" => "sini aja",
                "email" => "ksdfij@mail.com",
                "barcode" => "#19430821YTG",
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
        	],[
                "date_of_birth" => "1997-08-17",
                "gender" => "pria",
                "full_name" => "hadi riyadii",
                "member_category_id" => 2,
                "phone" => "87356883dss345f76",
                "address" => "sebelah mfasjid",
                "email" => "hadihadihadii@mail.com",
                "barcode" => "#19970817YTG",
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
            ]
        ];

    	Member::insert($data);
    }
}

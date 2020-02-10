<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                "full_name"=>"first admin",
                "username"=>"admin",
                "password"=>bcrypt("password"),
                "user_role"=>"admin",
                "email"=>"admin1@me.com",
                "phone"=>"089767587685",
                "address"=>"times square st.3",
                "avatar"=>"storage/user/YWFhYWExNTYzNTIwNjAw.jpg",
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
        	],[
        		"id"=>2,
                "full_name"=>"kasir magang",
                "username"=>"kasir123",
                "password"=>bcrypt("password"),
                "user_role"=>"kasir",
                "email"=>"kasir1@me.com",
                "phone"=>"089767587777",
                "address"=>"pekunden pandanaran",
                "avatar"=>"storage/user/bGtqc2RmbGtqbGpkZmxna2oxNTYzODQ5MzYw.png",
                "created_at"    =>  Carbon::now(),
                "updated_at"    =>  Carbon::now()
            ]
        ];

    	User::insert($data);
    }
}

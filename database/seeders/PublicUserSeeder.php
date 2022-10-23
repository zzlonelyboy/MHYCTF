<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=\Faker\Factory::create('zh_CN');
        $data=[];
        for($i=0;$i<100;$i++)
        {
            $data[]=[
                'username' => $faker->userName,
                'password'=>bcrypt('123456'),
                'email'=>$faker->email,
                'sex'=>rand(0,1),
                'created_at'=>date('Y-m-d H:i:s',time()),
            ];
        }
        DB::table('users')->insert($data);
    }
}

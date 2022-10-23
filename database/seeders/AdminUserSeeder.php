<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
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
        $data[]=[
            'username' => 'foolman',
            'password'=>bcrypt('2020212784'),
            'email'=>$faker->email,
            'sex'=>1,
            'created_at'=>date('Y-m-d H:i:s',time()),
        ];
        $data2[]=[
            'username' => 'ASEEE',
            'password'=>bcrypt('2021212027'),
            'email'=>$faker->email,
            'sex'=>1,
            'created_at'=>date('Y-m-d H:i:s',time()),
        ];
        DB::table('admin')->insert($data);
        DB::table('admin')->insert($data2);
    }
}

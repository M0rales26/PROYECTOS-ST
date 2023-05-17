<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        $admin = [
            [
                'name' => 'Admin Soltiend',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456789'),
                'fotop' => '1.jpg',
                'direccion' => 'Calle 1 Numero 2',
                'rol_id' => 3,
            ],
        ];
        DB::table('tbl_usuario')->insert($admin);
    }
}

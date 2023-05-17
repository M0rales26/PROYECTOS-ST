<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tbl_RolSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $rol = [
            ['rol' => 'Cliente'],
            ['rol' => 'Tendero'],
            ['rol' => 'Admin'],
        ];
        DB::table('tbl_rol')->insert($rol);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbl_Rol extends Model{
    use HasFactory;
    protected $primaryKey = 'id_rol';
    public $table = "tbl_rol";
    public $timestamps = false;
}

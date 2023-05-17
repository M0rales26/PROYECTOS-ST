<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbl_Listado_Nombresp extends Model{
    use HasFactory;
    protected $primaryKey = 'id_nombrep';
    public $table = "tbl_listado_nombresp";

    protected $fillable = [
        'nombre',
    ];
}

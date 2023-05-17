<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbl_Producto extends Model{
    use HasFactory;
    protected $primaryKey = 'id_producto';
    public $table = "tbl_producto";

    protected $fillable = [
        'nombrep',
        'precio',
        'peso_neto',
        'stock',
        'foto',
        'estado',
        'usuario_id'
    ];
}

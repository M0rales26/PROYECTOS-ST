<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbl_Factura_Producto extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_factura_producto';
    public $table = "tbl_factura_producto";

    protected $fillable = [
        'total_producto',
        'cantidad',
        'cliente_id',
        'tendero_id',
        'producto_id',
        'factura_id',
        'estado',
        'updated_at',
        'created_at',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbl_Factura extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_factura';
    public $table = "tbl_factura";

    protected $fillable = [
        'total',
        'cliente_id',
    ];
}

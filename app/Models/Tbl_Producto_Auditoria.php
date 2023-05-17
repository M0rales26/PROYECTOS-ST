<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbl_Producto_Auditoria extends Model{
    use HasFactory;
    //      //
    protected $primaryKey = 'id_producto_auditoria';
    public $table = "tbl_producto_auditoria";
    //  //
    protected $fillable = [
        'producto_id',
        'usuario_id',
        'accion',
        'precio',
    ];
    //      //
    public function producto(){
        return $this->belongsTo(Tbl_Producto::class);
    }
}
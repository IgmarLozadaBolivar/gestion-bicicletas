<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    /** @use HasFactory<\Database\Factories\AlquilerFactory> */
    use HasFactory;

    protected $table = 'alquilers';

    protected $fillable = [
        'user_id',
        'bicycle_id',
        'direccion_id',
        'start_time',
        'end_time',
        'valor_principal',
        'valor_adicional',
        'valor_total',
        'metodo_pago',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bicycle(){
        return $this->belongsTo(Bicycle::class);
    }

    public function direccion(){
        return $this->belongsTo(Direccion::class);
    }
}

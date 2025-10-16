<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bicycle extends Model
{
    use HasFactory;

    protected $table = 'bicycles';

    protected $fillable = [
        'marca',
        'modelo',
        'color',
        'estado',
        'latitude',
        'longitude',
        'precio',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function alquiler()
    {
        return $this->hasMany(Alquiler::class, 'bicycle_id');
    }
}

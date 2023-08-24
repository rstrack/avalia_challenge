<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /* O Eloquent ORM cria automaticamente os campos 'created_at' e 'updated_at',
    não sendo necessária a declaração da coluna 'registration_date'*/
    protected $fillable = [
        'name',
        'brand',
        'year',
        'plate',
        'sale_value',
    ];
    protected $casts = [
        'sale_value' => 'decimal:2',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarEngine extends Model
{
    protected $table = 'car_engines';

    protected $fillable = [
        'model_id',
        'engine_code',
        'volume',
        'fuel_type',
        'horsepower',
        'transmission',
    ];

    protected $casts = [
        'volume' => 'decimal:2',
    ];

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function compatibilities()
    {
        return $this->hasMany(ProductCompatibility::class, 'engine_id');
    }
}

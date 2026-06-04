<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models';

    protected $fillable = [
        'brand_id',
        'name',
        'code',
        'production_year_start',
        'production_year_end',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function engines()
    {
        return $this->hasMany(CarEngine::class, 'model_id');
    }
}

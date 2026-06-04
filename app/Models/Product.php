<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'oem_code',
        'category_id',
        'manufacturer_id',
        'description',
        'cost_price',
        'selling_price',
        'wholesale_price',
        'min_stock',
        'max_stock',
        'is_active',
        'last_stock_check',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'last_stock_check' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function analogs()
    {
        return $this->belongsToMany(Product::class, 'product_analogs', 'product_id', 'analog_id');
    }

    public function compatibilities()
    {
        return $this->hasMany(ProductCompatibility::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}

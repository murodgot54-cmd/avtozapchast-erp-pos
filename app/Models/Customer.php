<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'city',
        'country',
        'tax_id',
        'customer_type',
        'loyalty_balance',
        'debt_balance',
        'joined_date',
        'last_purchase',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'loyalty_balance' => 'decimal:2',
        'debt_balance' => 'decimal:2',
        'joined_date' => 'date',
        'last_purchase' => 'datetime',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function discounts()
    {
        return $this->hasMany(CustomerDiscount::class);
    }

    public function debts()
    {
        return $this->hasMany(CustomerDebt::class);
    }
}

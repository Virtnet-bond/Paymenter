<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'products',
        'expiry_date',
        'status',
        'client',
        'coupon',
    ];

    public function total()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $product->price = $product->price ?? $product->product()->get()->first()->price;
            $total += $product->price * $product->quantity;
        }

        return $total;
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client', 'id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon', 'id');
    }
}
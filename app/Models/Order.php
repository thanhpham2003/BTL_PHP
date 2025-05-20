<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'customer_name', 'customer_phone', 'customer_address', 'status', 'total_price', 'payment_method'];

    public function user()
    {
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

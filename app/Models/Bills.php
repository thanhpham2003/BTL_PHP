<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'address',
        'products',
        'total_amount',
        'payment_method',
        'ordered_at',
        'note',
        'order_id',
    ];

    protected $casts = [
        'products' => 'array',
        'ordered_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'content',
        'menu_id',
        'price',
        'price_sale',
        'active',
        'thumb',
        'size'
    ];
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }
    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id', 'id')->withDefault(['name' => '']);
    }


public function reviews(): HasMany
{
    return $this->hasMany(Review::class, 'product_id');
}
}

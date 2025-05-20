<?php

namespace App\Http\Business;

use App\Http\Services\Product\ProductService;
use App\Models\Product;
use App\Models\Size;

class CartItem
{
    protected int $productId;
    protected int $sizeId;
    protected int $quantity;
    protected Product $product;
    
    public function __construct(int $productId, int $sizeId, int $quantity)
    {
        $this->productId = $productId;
        $this->sizeId = $sizeId;
        $this->quantity = $quantity;
        $this->product = resolve(ProductService::class)->show($productId);
    }

    public function __get($name)
    {
        return $this->{$name} ?? null;
    }

    public function increase(int $quantity)
    {
        $this->quantity += $quantity;
    }

    public function getSize()
    {
        return Size::find($this->sizeId); // Lấy size từ database
    }

    public function total(){
        $price = $this->product->price_sale ?? $this->product->price;
        return $price * $this->quantity;
    }

    public function updateQuantity(int $quantity){
        $this->quantity = $quantity;
    }

    public function refresh()
    {
        $this->product = resolve(ProductService::class)->show($this->productId);
    }
}

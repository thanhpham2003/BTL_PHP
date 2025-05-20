<?php

namespace App\Http\Business;

use App\Http\Services\Product\ProductService;
use Exception;
use Throwable;

/**
 * Trong kien truc DDD co aggreate 
 * Co root => Cart
 * CartItem la con cua CART
 */
class Cart
{
    static Cart $cart;
    const CART_PREFIX = "cart_manage";
    protected array $cartItems = [];
    protected int $userId;
    protected string $cartKey;

    private function __construct($userId)
    {
        $this->userId = $userId;
        $this->cartKey = static::CART_PREFIX . "_" . $this->userId;
        if ($this->checkCart()) {
            $this->cartItems = session($this->cartKey);
        } else {
            $this->putToSession();
        }
    }

    public static function getInstance(int $userId = null): Cart
    {
        if(empty(self::$cart)) self::$cart = new Cart($userId);
        return self::$cart;
    }

    public function addToCart(int $productId, int $sizeId, int $quantity)
    {
        $product = resolve(ProductService::class)->show($productId);
        if (empty($product)) throw new Exception("Product Not Found");
        $keyItem = $productId."_".$sizeId;

        if (!empty($this->cartItems)) {
            if(!empty($this->cartItems[$keyItem])){
                $this->cartItems[$keyItem]->increase($quantity);
            }else{
                $cartItem = new CartItem($productId, $sizeId, $quantity);
                $this->cartItems[$keyItem] = $cartItem;
            }
        } else {
            $cartItem = new CartItem($productId, $sizeId, $quantity);
            $this->cartItems[$keyItem] = $cartItem;
        }
    }

    public function updateCart($rowId, int $quantity){
        if(empty($this->cartItems[$rowId])){
            throw new Exception("Failed");
        }
        $item = $this->cartItems[$rowId];
        $item->updateQuantity($quantity);
        return $item;
    }

    public function removeCart($rowId)
    {
        if (isset($this->cartItems[$rowId])) {
            unset($this->cartItems[$rowId]);
            return true;
        }
        return false;
    }
    

    private function putToSession()
    {
        session()->put($this->cartKey, $this->cartItems);
        session()->save();
    }
    
    private function checkCart(): bool{
        return session()->has($this->cartKey);
    }

    public function content(): array
    {
        return $this->cartItems;
    }

    public function destroy(){
        $this->cartItems = [];
    }

    public function total(){
        $total = array_reduce($this->cartItems, function($total, $item){
            $total += $item->total();
            return $total;
        }, 0);
        return number_format($total);
    }

    public function rawTotal(){
        return array_reduce($this->cartItems, function($total, $item){
            $total += $item->total();
            return $total;
        }, 0);
    }

    public function refresh()
    {
        foreach($this->cartItems as $item){
            $item->refresh();
        }
    }
    
    public function __destruct()
    {
        $this->putToSession();
    }
}

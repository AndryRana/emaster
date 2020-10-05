<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersProduct extends Model
{
    public static function getOrderProducts($order_id)
    {
        $getOrderProducts = OrdersProduct::where('order_id', $order_id)->get();
        return $getOrderProducts;
    }
}

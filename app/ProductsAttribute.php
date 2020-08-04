<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    public function getAttrPrice()
    {
        $price = $this->price ;
        return number_format($price, 2, ',', ' ') . ' €';
    }

}

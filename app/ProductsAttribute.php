<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductsAttribute extends Model
{

    use Searchable;
    
    public function getAttrPrice()
    {
        $price = $this->price ;
        return number_format($price, 2, ',', ' ') . ' €';
    }

}

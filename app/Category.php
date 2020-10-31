<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use Searchable;
    public function categories()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }


}

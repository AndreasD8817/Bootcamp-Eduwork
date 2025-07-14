<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\product;

class ProductCategories extends Model
{
    public function product()
    {
        return $this->hasMany(products::class);
    }
}

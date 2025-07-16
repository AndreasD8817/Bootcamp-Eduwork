<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategories;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(ProductCategories::class);
    }
}

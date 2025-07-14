<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategories;

class product extends Model
{
    public function category()
    {
        return $this->belongsTo(product_categories::class);
    }
}

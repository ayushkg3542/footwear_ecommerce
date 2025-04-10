<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function categoryName()
    {
        return $this->belongsTo(Category::class, 'category', 'id'); 
    }

    public function firstImage()
{
    return $this->hasOne(ProductImage::class)->oldestOfMany();
}

    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItems::class, 'product_id', 'id');
    // }


}

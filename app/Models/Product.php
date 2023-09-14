<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'title',
        'price',
        'description',
        'available',
        'image',
    ];

    public function shoppingCarts () {
        return $this->hasMany(ShoppingCart::class, 'product_id');
    }

}

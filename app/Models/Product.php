<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
         'name_product',
    'price',
    'category_id',
    'description',
    'image',
    'stock',
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}

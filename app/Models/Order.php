<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'receiver_Name',
        'phone',
        'province_code',
        'district_code',
        'ward_code',
        'detail_address',
        'user_id'
       
    ];
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function province(){
        return $this->belongsTo(Province::class,'province_code','code');
    }
    public function district(){
        return $this->belongsTo(District::class,'district_code','code');
    }
    public function ward(){
        return $this->belongsTo(Ward::class,'ward_code','code');
    }
    // public function product(){
    //     return $this->belongsTo(Product::class);
    // }
    // public function category(){
    //     return $this->belongsTo(Category::class);
    // }
}

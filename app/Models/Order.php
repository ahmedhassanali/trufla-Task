<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['date','customer_id'];

    public function user(){
        return $this->belongsTo(user::class,'customer_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_products');
    }
}   

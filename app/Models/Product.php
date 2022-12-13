<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =['name','amount_avilable','cost','description','added_by'];

    public function user(){
        return $this->belongsTo(user::class,'added_by');
    }

    public function orders(){
        return $this->belongsToMany(order::class,'order_products');
    }
}

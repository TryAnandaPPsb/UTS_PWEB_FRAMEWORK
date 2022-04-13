<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //Mendefinisikan tabel
    protected $table = 'products';

    //Apa saja yang akan diinput user
    protected $fillable = ['product_name','product_type','product_price','expired_at'];
}

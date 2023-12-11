<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $table = 'products';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    public $fillable = ['nama', 'harga', 'stok'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    protected $fillable = ['product_id', 'action', 'data'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

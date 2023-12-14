<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dtrans extends Model
{
    use HasFactory;
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    public $fillable = ['htrans_kode', 'products_id', 'qty'];
}

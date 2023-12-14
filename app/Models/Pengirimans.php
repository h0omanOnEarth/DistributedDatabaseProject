<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengirimans extends Model
{
    use HasFactory;
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    public $fillable = ['lokasi', 'estimasi'];
}

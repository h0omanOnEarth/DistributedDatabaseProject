<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Htrans extends Model
{
    use HasFactory;
    public $primaryKey = 'kode';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['kode', 'subtotal', 'status', 'pengirimans_id', 'users_id', 'ctr_estimasi'];
}

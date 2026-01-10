<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(KeranjangItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $guarded = ['id'];

    public function keranjangItems()
    {
        return $this->hasMany(KeranjangItem::class);
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }

    public function getRataRataRatingAttribute()
    {
        return $this->ulasan()->avg('rating') ?? 0;
    }
}

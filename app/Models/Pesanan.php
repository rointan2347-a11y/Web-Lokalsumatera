<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }


    public function kaosKustom()
    {
        return $this->belongsTo(KaosKustom::class, 'kaos_kustom_id');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }
}

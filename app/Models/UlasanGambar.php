<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanGambar extends Model
{
    use HasFactory;
    protected $table = 'ulasan_gambar';
    protected $guarded = ['id'];

    public function ulasan()
    {
        return $this->belongsTo(Ulasan::class);
    }
}

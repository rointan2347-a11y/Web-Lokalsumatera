<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaosKustom extends Model
{
    use HasFactory;
    protected $table = 'kaos_kustom';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function desainKaos()
    {
        return $this->belongsTo(DesainKaos::class);
    }

    public function keranjangItems()
    {
        return $this->hasMany(KeranjangItem::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('is_deleted', false);
    }
}

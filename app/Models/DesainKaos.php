<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesainKaos extends Model
{
    use HasFactory;
    protected $table = 'desain_kaos';
    protected $guarded = ['id'];

    public function kaosKustom()
    {
        return $this->hasMany(KaosKustom::class);
    }
}

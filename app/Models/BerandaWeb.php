<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerandaWeb extends Model
{
    use HasFactory;
    protected $table = 'beranda_web';
    protected $guarded = ['id'];
}

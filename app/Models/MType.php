<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MType extends Model
{
    use HasFactory;

    protected $table = 'tb_type';
    protected $primaryKey = 'tId';
    protected $guarded = [];
}

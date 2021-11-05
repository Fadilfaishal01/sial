<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLevis extends Model
{
    use HasFactory;

    protected $table = 'tb_levis';
    protected $primaryKey = 'lId';
    protected $fillable = [
        'lId', 'lName', 'typeId', 'brandId', 'lPrice', 'lDescription', 'lImage'
    ];
    protected $timestamp = false;


    public function Brand()
    {
        return $this->belongsTo(MBrand::class, 'brandId', 'bId');
    }

    public function Type()
    {
        return $this->belongsTo(MType::class, 'typeId', 'tId');
    }
}

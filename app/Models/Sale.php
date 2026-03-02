<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // 1. 保存を許可するカラムを指定
    protected $fillable = [
        'product_id',
    ];

    // 2. productsテーブルとのリレーション（1対多の「多」側）
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
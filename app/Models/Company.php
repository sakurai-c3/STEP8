<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // 1. 保存を許可するカラムを指定
    protected $fillable = [
        'company_name',
        'street_address',
        'representative_name',
    ];

    // 2. productsテーブルとのリレーション（1対多の「1」側）
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
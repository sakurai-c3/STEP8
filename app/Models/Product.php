<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 1. 保存を許可するカラムを指定（スネークケース）
    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    // 2. companiesテーブルとのリレーション（1対多の「多」側）
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
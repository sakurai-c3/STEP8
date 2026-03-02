<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id(int)
            $table->unsignedBigInteger('company_id'); // 外部キー用の列
            $table->string('product_name'); // 商品名
            $table->integer('price'); // 価格
            $table->integer('stock'); // 在庫数
            $table->text('comment')->nullable(); // コメント（空OK）
            $table->string('img_path')->nullable(); // 画像パス（空OK）
            $table->timestamps(); // 作成・更新日時

            // 外部キー制約：company_id は companiesテーブルのidを参照する
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

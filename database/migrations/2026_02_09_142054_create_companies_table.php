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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // id(int) / not null / オートインクリメント
            $table->string('company_name'); // varchar / not null
            $table->string('street_address')->nullable(); // varchar / null able
            $table->string('representative_name')->nullable(); // varchar / nullable
            $table->timestamps(); // created_at, updated_at / timestamp / notnull
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};

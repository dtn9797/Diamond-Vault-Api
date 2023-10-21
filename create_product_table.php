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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('metal');
            $table->string('description');
            $table->double('silverPrice');
            $table->double('goldPrice');
            $table->date('creationDate');
            $table->double('wholesalePrice');
            $table->double('retailPrice');
            $table->double('size');
            $table->string('category');
            $table->string('email')->unique();
            $table->string('ImageUrl');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};

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
        Schema::create('price_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_list_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('article_number')->nullable();
            $table->unsignedDecimal('price');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::raw('ALTER TABLE price_list_items ADD SYSTEM VERSIONING;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::raw('ALTER TABLE price_list_items ADD SYSTEM VERSIONING;');
        Schema::dropIfExists('price_list_items');
    }
};

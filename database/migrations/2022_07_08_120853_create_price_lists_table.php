<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider');
            $table->date('validity_period')->nullable();
            $table->string('currency');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement(DB::raw('ALTER TABLE price_lists ADD SYSTEM VERSIONING'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(DB::raw('ALTER TABLE price_lists ADD SYSTEM VERSIONING'));
        Schema::dropIfExists('price_lists');
    }
};

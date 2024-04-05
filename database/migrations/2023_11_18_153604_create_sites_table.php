<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();

            $table->integer('image_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('warehouse')->nullable();
            $table->string('email')->nullable();
            $table->string('sites')->nullable();

            $table->string('company')->nullable();
            $table->string('hotline')->nullable();
            $table->string('technique')->nullable();

            $table->string('banner_top')->nullable();
            $table->string('url_banner')->nullable();

            $table->string('meta')->nullable();
            $table->string('keyword')->nullable();
            $table->string('description')->nullable();

            $table->text('analytic')->nullable();
            $table->string('facebook')->nullable();
            $table->string('map')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};

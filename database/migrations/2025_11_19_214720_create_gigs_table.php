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
     Schema::create('gigs', function (Blueprint $table) {
         $table->id();
         $table->string('title');
         $table->text('description')->nullable();
         $table->decimal('price', 10, 2);
         $table->string('category')->index();
         $table->unsignedBigInteger('seller_id')->index();
         $table->timestamps();
     });
 }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};

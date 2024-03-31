<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlabsTable extends Migration
{
    public function up(): void
    {
        Schema::create('slabs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('description');
            $table->integer('quantity');
            $table->string('supplier');
            $table->string('order_number')->nullable();
            $table->integer('price')->nullable();
            $table->string('polishment');
            $table->integer('thickness');
            $table->decimal('width');
            $table->decimal('length');
            $table->decimal('square_meters');
            $table->string('physical_position');
            $table->foreignId('user_id');
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slabs');
    }
}

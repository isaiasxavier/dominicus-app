<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeStoneToSlabsTable extends Migration
{
    public function up(): void
    {
        Schema::table('slabs', function (Blueprint $table) {
            $table->string('type_stone');
        });
    }

    /*public function down(): void
    {
        Schema::table('slabs', function (Blueprint $table) {
            $table->dropColumn('type_stone');
        });
    }*/
}

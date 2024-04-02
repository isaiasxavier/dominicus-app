<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeStoneInSlabsTable extends Migration
{
    public function up(): void
    {
        /* ->change() is powered by doctrine/dbal package, which is a wrapper
             around PDO. It allows to change the column type without dropping it.

        * Schema::table('slabs', function (Blueprint $table) {//
            $table->enum('type_stone', ['composite', 'granite', 'marble', 'quartz', 'quartzite', 'onyx', 'soapstone', 'porcelain', 'ceramic', 'dekton', 'neolith'])->change();
        });*/
        Schema::table('slabs', function (Blueprint $table) {
            $table->dropColumn('type_stone');
        });

        Schema::table('slabs', function (Blueprint $table) {
            $table->enum('type_stone',
                ['composite', 'granite', 'marble', 'quartz', 'quartzite', 'onyx',
                    'soapstone', 'porcelain', 'ceramic', 'dekton', 'neolith']);
        });
    }

    public function down(): void
    {
        Schema::table('slabs', function (Blueprint $table) {
            $table->dropColumn('type_stone');
        });

        Schema::table('slabs', function (Blueprint $table) {
            $table->string('type_stone');
        });
    }
}

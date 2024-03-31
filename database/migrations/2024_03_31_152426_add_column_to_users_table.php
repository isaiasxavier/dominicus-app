<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletesDatetime('deleted_at')->nullable();
        });
    }

    /*public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }*/
}

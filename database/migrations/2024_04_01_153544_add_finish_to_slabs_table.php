<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinishToSlabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * This method adds a new column 'finish' to the 'slabs' table.
     * The 'finish' column is an enumerated type with the following possible values: 'geschuurd', 'gezoet', 'gepolijst'.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('slabs', function (Blueprint $table) {
            $table->enum('finish',
                ['geschuurd', 'gezoet', 'gepolijst']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method removes the 'finish' column from the 'slabs' table.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('slabs', function (Blueprint $table) {
            $table->dropColumn('finish');
        });
    }
}

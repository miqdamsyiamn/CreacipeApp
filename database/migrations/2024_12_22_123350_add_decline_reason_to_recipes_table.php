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
        Schema::table('recipes', function (Blueprint $table) {
             // Menambahkan kolom decline_reason bertipe TEXT, bisa bernilai NULL
            $table->text('decline_reason')->nullable()->after('declined_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            // Menghapus kolom decline_reason jika rollback
            $table->dropColumn('decline_reason');
        });
    }
};

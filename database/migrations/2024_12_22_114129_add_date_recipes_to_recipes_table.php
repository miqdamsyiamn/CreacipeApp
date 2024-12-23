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
            $table->date('created_date')->nullable();   // Tanggal dibuat oleh member
            $table->date('accepted_date')->nullable();  // Tanggal diterima editor
            $table->date('declined_date')->nullable();  // Tanggal ditolak editor
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
            // Menghapus kolom saat rollback
            $table->dropColumn(['created_date', 'accepted_date', 'declined_date']);
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan foreign key pada kolom status_id yang sudah ada
            $table->foreign('status_id') // Menghubungkan ke kolom status_id
                ->references('status_id') // Referensi ke status_id di tabel status
                ->on('status')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key saat rollback
            $table->dropForeign(['status_id']);
        });
    }
};

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
        // Mengganti nama kolom 'id' menjadi 'role_id'
        Schema::table('roles', function (Blueprint $table) {
            $table->renameColumn('id', 'role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback perubahan dari 'role_id' menjadi 'id'
        Schema::table('roles', function (Blueprint $table) {
            $table->renameColumn('role_id', 'id');
        });
    }
};

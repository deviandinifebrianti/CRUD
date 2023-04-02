<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Mahasiswas', function (Blueprint $table) {
            $table->date('Tanggal_Lahir')->after('Nama');
            $table->string('Email', 100)->after('Jurusan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Mahasiswas', function (Blueprint $table) {
            $table->dropColumn('Tanggal_Lahir');
            $table->dropColumn('Email');
        });
    }
};

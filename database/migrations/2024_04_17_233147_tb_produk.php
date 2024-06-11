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
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('kode_bibit', length: 255)->nullable();
            $table->string('nama_bibit', length: 255)->nullable();
            $table->string('detail_bibit', length: 255)->nullable();
            $table->string('harga_bibit', length: 255)->nullable();
            $table->string('stok_bibit', length: 255)->nullable();
            $table->string('gambar_bibit', length: 255)->nullable();
            $table->string('status_bibit', length: 255)->nullable();
            $table->string('created_bibit', length: 255)->nullable();
            $table->string('updated_bibit', length: 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

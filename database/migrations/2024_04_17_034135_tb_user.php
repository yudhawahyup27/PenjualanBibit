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
        //
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_user', length: 255)->nullable();
            $table->string('nomortelepon_user', length: 255)->nullable();
            $table->string('alamat_user', length: 255)->nullable();
            $table->string('email_user', length: 255)->nullable();
            $table->string('username_user', length: 255)->nullable();
            $table->string('password_user', length: 255)->nullable();
            $table->string('role_user', length: 255)->nullable();
            $table->string('status_user', length: 255)->nullable();
            $table->string('created_user', length: 255)->nullable();
            $table->string('updated_user', length: 255)->nullable();
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

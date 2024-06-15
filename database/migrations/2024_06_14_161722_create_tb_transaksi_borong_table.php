<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTransaksiBorongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi_borong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_transaksi');
            $table->string('kode_transaksi');
            $table->string('nama_bibit');
            $table->date('tanggal_tanam');
            $table->string('luas_lahan');
            $table->integer('kuantitas_bibit');
            $table->decimal('total_transaksi', 10, 2);
            $table->string('bukti_pembayaran');
            $table->unsignedBigInteger('pengiriman');
            $table->unsignedBigInteger('metodepembayaran');
            $table->tinyInteger('status_transaksi')->default(1);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user_transaksi')->references('id_user')->on('tb_user')->onDelete('cascade');
            // Add more foreign key constraints if needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_transaksi_borong');
    }
}

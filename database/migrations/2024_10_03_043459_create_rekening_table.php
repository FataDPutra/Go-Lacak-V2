<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningTable extends Migration
{
    public function up()
    {
        Schema::create('rekening', function (Blueprint $table) {
            // UUID sebagai primary key
            $table->uuid('id')->primary();
            
            // Kolom nomor rekening yang unik
            $table->string('no_rek')->unique();
            
            // Foreign key yang terhubung ke tabel programs
            $table->uuid('program_id');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            
            // Timestamps untuk created_at dan updated_at
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekening');
    }
}

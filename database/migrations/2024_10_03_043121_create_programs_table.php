<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            // Menggunakan UUID sebagai primary key
            $table->uuid('id')->primary();
            
            // Nama program
            $table->string('nama_program');
            
            // Status (program, subprogram, atau kegiatan)
            $table->enum('status', ['program', 'subprogram', 'kegiatan'])->default('program');
            
            // Timestamp untuk created_at dan updated_at
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
}

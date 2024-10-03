<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            // UUID sebagai primary key
            $table->uuid('id')->primary();
            
            // Kolom nama program
            $table->string('nama_program');
            
            // Kolom status (program, subprogram, atau kegiatan)
            $table->enum('status', ['program', 'subprogram', 'kegiatan'])->default('program');
            
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
}

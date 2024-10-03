<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    // Pastikan tabel yang digunakan adalah 'rekening'
    protected $table = 'rekening'; // Nama tabel sesuai dengan migrasi

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['no_rek', 'program_id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) \Illuminate\Support\Str::uuid();
        });
    }
}

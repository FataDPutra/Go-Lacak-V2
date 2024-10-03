<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    // Mengisi UUID secara otomatis saat create
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) \Illuminate\Support\Str::uuid();
        });
    }

    // Kolom yang bisa diisi
    protected $fillable = ['no_rek', 'program_id'];

    // Relasi Many-to-One ke Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}

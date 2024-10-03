<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
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
    protected $fillable = ['nama_program', 'status'];

    // Relasi One-to-Many ke Rekening
    public function rekenings()
    {
        return $this->hasMany(Rekening::class);
    }
}

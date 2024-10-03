<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['nama_program', 'status'];

    // Definisikan relasi ke model Rekening (hasMany)
    public function rekenings()
    {
        return $this->hasMany(Rekening::class, 'program_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) \Illuminate\Support\Str::uuid();
        });
    }
}

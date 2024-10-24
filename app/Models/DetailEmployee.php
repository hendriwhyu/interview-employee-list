<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetailEmployee extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi (mass-assignable)
    protected $fillable = [
        'employee_id',
        'date_of_birth',
        'gender',
        'province',
        'city',
        'district',
        'village',
        'address',
    ];

    public $timestamps = false;

    /**
     * Relasi ke model Employee (One to One)
     * Setiap detail pegawai terhubung ke satu pegawai
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}

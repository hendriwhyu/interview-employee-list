<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'position',
        'phone_number',
        'entry_date',
        'photo',
        'documents'
    ];

    /**
     * Relasi ke model Document (satu karyawan bisa memiliki banyak dokumen).
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relasi ke model DetailEmployee (One to One)
     * Setiap pegawai terhubung ke satu detail pegawai
     */
    public function detailEmployee(): HasOne
    {
        return $this->hasOne(DetailEmployee::class);
    }
}

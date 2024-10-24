<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    /**
     * Relasi ke model Document (satu karyawan bisa memiliki banyak dokumen).
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

}

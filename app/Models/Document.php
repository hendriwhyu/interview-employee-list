<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'path',
        'filename',
    ];

    /**
     * Relasi ke model Employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

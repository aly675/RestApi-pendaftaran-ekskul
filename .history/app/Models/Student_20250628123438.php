<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    protected $table = '';

    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'street',
        'grade',
        'major',
    ];

    public function extracurriculars()
    {
        return $this->belongsToMany(Extracurricular::class);
    }
}

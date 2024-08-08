<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionInfo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questionSubjectInfo()
    {
        return $this->hasMany(QuestionSubjectInfo::class);
    }
}

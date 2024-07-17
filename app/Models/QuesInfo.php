<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuesInfo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questionPapers()
    {
        return $this->hasMany(QuestionPaper::class);
    }
}

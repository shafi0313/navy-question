<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSubjectInfo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questionPapers()
    {
        return $this->hasMany(QuestionPaper::class);
    }

    public function markDistribution()
    {
        return $this->belongsTo(MarkDistribution::class, 'subject_id', 'subject_id');
    }
}

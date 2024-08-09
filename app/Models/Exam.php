<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    

    // public function questionPaper()
    // {
    //     return $this->hasOne(QuestionPaper::class, 'exam_id');
    // }

    // public function subject(){
    //     return $this->belongsTo(Subject::class, 'subject_id');
    // }
    // public function enroll()
    // {
    //     return $this->hasOne(Enroll::class, 'exam_id');
    // }

    // public function ans()
    // {
    //     return $this->hasOne(QuesAns::class, 'exam_id');
    // }
}

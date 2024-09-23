<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class)->withDefault([
            'name' => 'N/A',
        ]);
    }

    public function exam()
    {
        return $this->belongsTo(Subject::class)->withDefault([
            'name' => 'N/A',
        ]);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class)->withDefault([
            'name' => 'N/A',
        ]);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function options()
    {
        return $this->hasMany(QuesOption::class, 'question_id');
    }

    public function enroll()
    {
        return $this->belongsTo(Enroll::class, 'exam_id');
    }
}

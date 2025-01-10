<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function markDistribution()
    {
        return $this->hasOne(MarkDistribution::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    // public function exam()
    // {
    //     return $this->belongsTo(Exam::class);
    // }
}

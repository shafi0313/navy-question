<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function markDistribution(){
        return $this->hasOne(MarkDistribution::class);
    }
    public function question(){
        return $this->hasMany(Question::class, 'chapter_id', 'id');
    }
}

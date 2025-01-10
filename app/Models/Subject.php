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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault([
            'name' => 'System',
        ]);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault([
            'name' => 'System',
        ]);
    }
}

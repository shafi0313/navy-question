<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault([
            'name' => 'System'
        ]);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault([
            'name' => ''
        ]);
    }
}

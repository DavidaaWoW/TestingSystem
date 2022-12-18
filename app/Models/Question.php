<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'test',
        'question_variation',
        'score'
    ];

    public function questionVariation(){
        return $this->belongsTo(QuestionVariation::class, 'question_variation');
    }

    public function test(){
        return $this->belongsTo(Test::class, 'test');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_question', 'question', 'user')->withPivot('score')->withTimestamps();
    }

    public function answers(){
        return $this->hasMany(Answer::class, 'question');
    }
}

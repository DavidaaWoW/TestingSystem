<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'discipline',
        'time',
        'pass_score',
        'order_number'
    ];

    public function userTest(){
        return $this->hasMany(UserTest::class, 'test');
    }

    public function discipline(){
        return $this->belongsTo(Discipline::class, 'discipline');
    }

    public function questions(){
        return $this->hasMany(Question::class, 'test');
    }

}

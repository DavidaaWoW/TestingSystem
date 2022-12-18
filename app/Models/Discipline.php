<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    public $incrementing = false;


    protected $fillable = [
        'id',
        'name',
        'img'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'user_discipline', 'discipline', 'user');
    }

    public function tests(){
        return $this->hasMany(Test::class, 'discipline');
    }
}

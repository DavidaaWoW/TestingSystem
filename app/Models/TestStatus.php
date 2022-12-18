<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestStatus extends Model
{
    use HasFactory;

    protected $table = 'test_statuses';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name'
    ];

    public function userTests(){
        return $this->hasMany(UserTest::class, 'status');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserTest extends Model
{
    use HasFactory;

    protected $table = 'user_test';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user',
        'test',
        'status'
    ];

    public function setEndTimeAttribute($endtime)
    {
        $this->attributes['endtime'] = Carbon::parse($endtime);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user');
    }

    public function test(){
        return $this->belongsTo(Test::class, 'test');
    }

    public function status(){
        return $this->belongsTo(TestStatus::class, 'status');
    }
}

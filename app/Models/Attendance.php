<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['user_id', 'attendance_date', 'status'];
    protected $guarded = ['use_id']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}

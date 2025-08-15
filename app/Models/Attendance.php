<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id','date','location','check_in','check_out','late_check_in','late_check_out','note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

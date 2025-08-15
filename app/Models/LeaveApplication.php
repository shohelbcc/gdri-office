<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $fillable = [
        'user_id',
        'apply_date',
        'start_date',
        'end_date',
        'total_days',
        'type',
        'reason',
        'status',
        'signature',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

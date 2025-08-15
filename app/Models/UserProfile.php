<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'photo',
        'address',
        'division',
        'district',
        'thana',
        'postal_code',
        'designation',
        'emp_id',
        'dob',
        'work_office',
        'employee_status',
        'links',
        'biography',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

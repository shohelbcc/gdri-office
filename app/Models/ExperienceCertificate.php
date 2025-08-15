<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceCertificate extends Model
{
    protected $fillable = [
        'certificate_number',
        'certificate',
    ];
}

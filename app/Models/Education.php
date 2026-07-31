<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    // Eloquent treats "Education" as uncountable and would guess table 'education' otherwise
    protected $table = 'educations';

    protected $fillable = [
        'institution',
        'degree',
        'field',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}

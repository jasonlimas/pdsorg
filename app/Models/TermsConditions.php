<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsConditions extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'terms_conditions',
    ];

    protected $casts = [
        'terms_conditions' => 'array',
    ];
}

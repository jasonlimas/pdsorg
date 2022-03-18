<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sender extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'bank_institution',
        'bank_account_name',
        'bank_account_number',
    ];

    protected $casts = [
        'bank_info' => 'array',
    ];

    public function quotes()
    {
        return $this->hasMany(Quotation::class);
    }
}

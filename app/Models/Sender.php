<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    public function quotes()
    {
        return $this->hasMany(Quotation::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotes';

    protected $fillable = [
        'div',
        'sales_person',
        'number',
        'quote_date',
        'sender_id',
        'client_id',
        'items',
        'tax',
        'terms_conditions',
        'amount',
    ];

    protected $casts = [
        'items' => 'array',
        'terms_conditions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(Sender::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
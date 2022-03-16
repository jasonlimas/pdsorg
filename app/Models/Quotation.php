<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Quotation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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
        'status_id',
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

    public function status()
    {
        return $this->hasOne(QuoteStatus::class);
    }
}

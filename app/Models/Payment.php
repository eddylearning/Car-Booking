<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'mpesa_receipt',
        'phone',
        'amount',
        'status',
        'response'
    ];

    protected $casts = [
        'response' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

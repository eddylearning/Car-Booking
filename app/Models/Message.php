<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'sender_id',
        'sender_role',
        'message',
    ];

    /**
     * A message belongs to a booking.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * A message may belong to a user (sender).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}

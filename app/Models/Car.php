<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model',
        'type',
        'image',
        'mileage',
        'price_per_day',
        'available',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_per_day' => 'decimal:2',
        'available' => 'boolean',
    ];

    /**
     * Get the bookings for the car.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id', 'title', 'description', 'price', 'type', 'property_type',
        'city', 'address', 'rooms', 'bathrooms', 'surface', 'features',
        'is_available', 'latitude', 'longitude', 'year_built', 'is_featured',
        'status', 'neighborhood', 'postal_code'
    ];

    protected $casts = [
        'features' => 'array',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
    ];


    // Relations
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function rentalContracts(): HasMany
    {
        return $this->hasMany(RentalContract::class);
    }

    public function saleContracts(): HasMany
    {
        return $this->hasMany(SaleContract::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(PropertyRequest::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PropertyVisit::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(PropertyFavorite::class);
    }


    // Scopes pour le filtrage
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeForSale($query)
    {
        return $query->where('type', 'sale')->where('status', 'available');
    }

    public function scopeForRent($query)
    {
        return $query->where('type', 'rent')->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

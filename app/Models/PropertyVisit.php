<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyVisit extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'user_id',
        'visit_date',
        'status',
        'notes',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visit_date' => 'datetime',
    ];

    /**
     * Obtenir la propriété concernée par cette visite.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Obtenir l'utilisateur qui a programmé cette visite.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les visites à venir.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('visit_date', '>=', now())
            ->where('status', 'scheduled');
    }

    /**
     * Scope pour les visites passées.
     */
    public function scopePast($query)
    {
        return $query->where('visit_date', '<', now())
            ->orWhere('status', 'completed');
    }
}

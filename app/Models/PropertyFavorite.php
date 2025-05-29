<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFavorite extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'property_id',
    ];

    /**
     * Indique si le modèle doit être horodaté.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Obtenir l'utilisateur qui a ajouté cette propriété aux favoris.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir la propriété mise en favori.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Scope pour obtenir les favoris d'un utilisateur spécifique.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope pour vérifier si une propriété est dans les favoris d'un utilisateur.
     */
    public function scopeIsFavorite($query, $userId, $propertyId)
    {
        return $query->where('user_id', $userId)
            ->where('property_id', $propertyId);
    }
}

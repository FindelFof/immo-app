<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyAlert extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'property_type',
        'city',
        'min_price',
        'max_price',
        'min_rooms',
        'min_bathrooms',
        'min_surface',
        'features',
        'type',
        'is_active',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'min_surface' => 'decimal:2',
        'min_rooms' => 'integer',
        'min_bathrooms' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Obtenir l'utilisateur qui a configuré cette alerte.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les alertes actives.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les alertes d'un utilisateur spécifique.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope pour les alertes de type vente.
     */
    public function scopeForSale($query)
    {
        return $query->where('type', 'sale');
    }

    /**
     * Scope pour les alertes de type location.
     */
    public function scopeForRent($query)
    {
        return $query->where('type', 'rent');
    }

    /**
     * Vérifier si une propriété correspond aux critères de cette alerte.
     */
    public function matchesProperty(Property $property): bool
    {
        // Vérifier le type de transaction
        if ($this->type && $property->type !== $this->type) {
            return false;
        }

        // Vérifier le type de propriété
        if ($this->property_type && $property->property_type !== $this->property_type) {
            return false;
        }

        // Vérifier la ville
        if ($this->city && $property->city !== $this->city) {
            return false;
        }

        // Vérifier le prix minimum
        if ($this->min_price && $property->price < $this->min_price) {
            return false;
        }

        // Vérifier le prix maximum
        if ($this->max_price && $property->price > $this->max_price) {
            return false;
        }

        // Vérifier le nombre minimum de pièces
        if ($this->min_rooms && $property->rooms < $this->min_rooms) {
            return false;
        }

        // Vérifier le nombre minimum de salles de bain
        if ($this->min_bathrooms && $property->bathrooms < $this->min_bathrooms) {
            return false;
        }

        // Vérifier la surface minimale
        if ($this->min_surface && $property->surface < $this->min_surface) {
            return false;
        }

        // Vérifier les caractéristiques demandées
        if ($this->features && is_array($this->features) && count($this->features) > 0) {
            $propertyFeatures = $property->features ?? [];

            // Vérifier si toutes les caractéristiques demandées sont présentes
            foreach ($this->features as $feature) {
                if (!in_array($feature, $propertyFeatures)) {
                    return false;
                }
            }
        }

        // Tous les critères sont satisfaits
        return true;
    }

    /**
     * Active l'alerte.
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Désactive l'alerte.
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }
}

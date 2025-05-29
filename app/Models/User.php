<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'role',
        'password',
        'profile_picture',
        'address',
        'birth_date',
        'identity_document',
    ];

    /**
     * Les attributs qui doivent être cachés pour les arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Détermine si l'utilisateur peut accéder au panneau d'administration Filament.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->role === 'admin' || $this->role === 'owner';
    }

    /**
     * Obtenir le nom à afficher dans Filament.
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }

    /**
     * Attribut calculé pour le nom complet.
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * URL de l'avatar à utiliser dans Filament.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Propriétés possédées par l'utilisateur (si role = owner).
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    /**
     * Contrats de location où l'utilisateur est locataire (si role = tenant).
     */
    public function rentalContracts(): HasMany
    {
        return $this->hasMany(RentalContract::class, 'tenant_id');
    }

    /**
     * Contrats de vente où l'utilisateur est acheteur.
     */
    public function saleContracts(): HasMany
    {
        return $this->hasMany(SaleContract::class, 'buyer_id');
    }

    /**
     * Demandes de propriété faites par l'utilisateur.
     */
    public function propertyRequests(): HasMany
    {
        return $this->hasMany(PropertyRequest::class);
    }

    /**
     * Paiements de loyer effectués par l'utilisateur (si role = tenant).
     */
    public function rentPayments(): HasMany
    {
        return $this->hasMany(RentPayment::class, 'tenant_id');
    }

    /**
     * Visites de propriété planifiées par l'utilisateur.
     */
    public function propertyVisits(): HasMany
    {
        return $this->hasMany(PropertyVisit::class);
    }

    /**
     * Propriétés favorites de l'utilisateur.
     */
    public function favoriteProperties(): HasMany
    {
        return $this->hasMany(PropertyFavorite::class);
    }

    /**
     * Alertes de propriété configurées par l'utilisateur.
     */
    public function propertyAlerts(): HasMany
    {
        return $this->hasMany(PropertyAlert::class);
    }

    /**
     * Scope pour les administrateurs.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope pour les propriétaires.
     */
    public function scopeOwners($query)
    {
        return $query->where('role', 'owner');
    }

    /**
     * Scope pour les locataires.
     */
    public function scopeTenants($query)
    {
        return $query->where('role', 'tenant');
    }

    /**
     * Scope pour les clients.
     */
    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    /**
     * Vérifier si l'utilisateur est un administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est un propriétaire.
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Vérifier si l'utilisateur est un locataire.
     */
    public function isTenant(): bool
    {
        return $this->role === 'tenant';
    }

    /**
     * Vérifier si l'utilisateur est un client.
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }
}

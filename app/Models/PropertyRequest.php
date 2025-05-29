<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'user_id',
        'type',
        'message',
        'status',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtenir la propriété concernée par cette demande.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Obtenir l'utilisateur qui a fait cette demande.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les demandes en attente.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les demandes acceptées.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope pour les demandes rejetées.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope pour les demandes de location.
     */
    public function scopeRentRequests($query)
    {
        return $query->where('type', 'rent');
    }

    /**
     * Scope pour les demandes d'achat.
     */
    public function scopePurchaseRequests($query)
    {
        return $query->where('type', 'purchase');
    }

    /**
     * Vérifier si la demande est en attente.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifier si la demande est acceptée.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Vérifier si la demande est rejetée.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Mettre à jour le statut de la demande à "accepté".
     */
    public function accept(): bool
    {
        return $this->update(['status' => 'accepted']);
    }

    /**
     * Mettre à jour le statut de la demande à "rejeté".
     */
    public function reject(): bool
    {
        return $this->update(['status' => 'rejected']);
    }
}

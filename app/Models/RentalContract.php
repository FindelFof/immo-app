<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class RentalContract extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'contract_number',
        'property_id',
        'tenant_id',
        'contract_date',
        'start_date',
        'end_date',
        'final_end_date',
        'monthly_rent',
        'deposit',
        'status',
        'others_fees'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'final_end_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'deposit' => 'decimal:2',
        'others_fees' => 'array',
    ];

    /**
     * Obtenir la propriété concernée par ce contrat de location.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Obtenir le locataire concerné par ce contrat de location.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }    public function tenantq(): BelongsTo
    {
        return $this->belongsTo(User::class, );
    }

    /**
     * Obtenir les paiements de loyer liés à ce contrat.
     */
    public function rentPayments(): HasMany
    {
        return $this->hasMany(RentPayment::class);
    }

    /**
     * Scope pour les contrats actifs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope pour les contrats expirés.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Scope pour les contrats résiliés.
     */
    public function scopeTerminated($query)
    {
        return $query->where('status', 'terminated');
    }

    /**
     * Scope pour les contrats qui expirent bientôt (dans les 30 jours).
     */
    public function scopeExpiringIn30Days($query)
    {
        $thirtyDaysFromNow = now()->addDays(30);
        return $query->where('status', 'active')
            ->where('end_date', '<=', $thirtyDaysFromNow)
            ->where('end_date', '>=', now());
    }

    /**
     * Scope pour les contrats d'un propriétaire spécifique.
     */
    public function scopeByOwner($query, $ownerId)
    {
        return $query->whereHas('property', function ($q) use ($ownerId) {
            $q->where('owner_id', $ownerId);
        });
    }

    /**
     * Scope pour les contrats d'un locataire spécifique.
     */
    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Vérifier si le contrat est actif.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Vérifier si le contrat est expiré.
     */
    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    /**
     * Vérifier si le contrat est résilié.
     */
    public function isTerminated(): bool
    {
        return $this->status === 'terminated';
    }

    /**
     * Calculer la durée du contrat en mois.
     */
    public function getDurationInMonths(): int
    {
        return $this->start_date->diffInMonths($this->end_date);
    }

    /**
     * Calculer le montant total du loyer pour la durée du contrat.
     */
    public function getTotalRentAmount(): float
    {
        return $this->monthly_rent * $this->getDurationInMonths();
    }

    /**
     * Obtenir le montant total des loyers payés.
     */
    public function getTotalPaidAmount(): float
    {
        return $this->rentPayments()
            ->where('status', 'paid')
            ->sum('amount');
    }

    /**
     * Obtenir le montant des loyers impayés.
     */
    public function getUnpaidAmount(): float
    {
        return $this->getTotalRentAmount() - $this->getTotalPaidAmount();
    }

    /**
     * Vérifier si le contrat expire bientôt (dans les 30 jours).
     */
    public function isExpiringSoon(): bool
    {
        return $this->isActive() && $this->end_date->diffInDays(now()) <= 30;
    }

    /**
     * Terminer le contrat.
     */
    public function terminate(): bool
    {
        return $this->update(['status' => 'terminated']);
    }

    /**
     * Marquer le contrat comme expiré.
     */
    public function markAsExpired(): bool
    {
        return $this->update(['status' => 'expired']);
    }

    /**
     * Renouveler le contrat pour une période spécifiée.
     */
    public function renew($months, $newMonthlyRent = null): bool
    {
        $newStartDate = $this->end_date->copy()->addDay();
        $newEndDate = $newStartDate->copy()->addMonths($months)->subDay();

        return $this->update([
            'start_date' => $newStartDate,
            'end_date' => $newEndDate,
            'monthly_rent' => $newMonthlyRent ?? $this->monthly_rent,
            'status' => 'active',
        ]);
    }

    /**
     * Générer automatiquement un numéro de contrat unique lors de la création.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            if (empty($contract->contract_number)) {
                $prefix = 'LOC-';
                $year = date('Y');
                $lastContract = self::whereYear('created_at', $year)
                    ->latest()
                    ->first();

                $number = $lastContract ? intval(substr($lastContract->contract_number, -5)) + 1 : 1;
                $contract->contract_number = $prefix . $year . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}

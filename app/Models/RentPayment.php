<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class RentPayment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rental_contract_id',
        'due_date',
        'payment_date',
        'amount',
        'payment_reference',
        'payment_method',
        'status',
        'notes',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Obtenir le contrat de location associé à ce paiement.
     */
    public function rentalContract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class);
    }

    /**
     * Obtenir le locataire associé à ce paiement.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Scope pour les paiements en attente.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les paiements payés.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope pour les paiements en retard.
     */
    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    /**
     * Scope pour les paiements dus aujourd'hui ou avant.
     */
    public function scopeDueToday($query)
    {
        return $query->where('due_date', '<=', now()->format('Y-m-d'))
            ->where('status', 'pending');
    }

    /**
     * Scope pour les paiements à venir.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('due_date', '>', now()->format('Y-m-d'))
            ->where('status', 'pending');
    }

    /**
     * Scope pour les paiements filtrés par méthode de paiement.
     */
    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * Scope pour les paiements d'un contrat spécifique.
     */
    public function scopeByContract($query, $contractId)
    {
        return $query->where('rental_contract_id', $contractId);
    }

    /**
     * Scope pour les paiements d'un locataire spécifique.
     */
    public function scopeByTenant($query, $tenantId)
    {
        return $query->whereHas('rentalContract', function ($q) use ($tenantId) {
            $q->where('tenant_id', $tenantId);
        });
    }

    /**
     * Vérifier si le paiement est en attente.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifier si le paiement est payé.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Vérifier si le paiement est en retard.
     */
    public function isLate(): bool
    {
        return $this->status === 'late';
    }

    /**
     * Vérifier si le paiement est dû aujourd'hui.
     */
    public function isDueToday(): bool
    {
        return $this->due_date->isToday() && $this->isPending();
    }

    /**
     * Vérifier si le paiement est en retard (date d'échéance passée et non payé).
     */
    public function isOverdue(): bool
    {
        return $this->due_date->isPast() && $this->isPending();
    }

    /**
     * Calculer le nombre de jours de retard.
     */
    public function getDaysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return $this->due_date->diffInDays(now());
    }

    /**
     * Marquer le paiement comme payé.
     */
    public function markAsPaid($paymentDate = null, $paymentMethod = null, $paymentReference = null): bool
    {
        $data = [
            'status' => 'paid',
            'payment_date' => $paymentDate ?? now(),
        ];

        if ($paymentMethod) {
            $data['payment_method'] = $paymentMethod;
        }

        if ($paymentReference) {
            $data['payment_reference'] = $paymentReference;
        }

        return $this->update($data);
    }

    /**
     * Marquer le paiement comme en retard.
     */
    public function markAsLate(): bool
    {
        return $this->update(['status' => 'late']);
    }

    /**
     * Générer automatiquement une référence de paiement unique lors de la création.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_reference)) {
                $prefix = 'PAY-';
                $year = date('Y');
                $month = date('m');
                $lastPayment = self::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->latest()
                    ->first();

                $number = $lastPayment ? intval(substr($lastPayment->payment_reference, -5)) + 1 : 1;
                $payment->payment_reference = $prefix . $year . $month . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
            }
        });

        // Vérifiez automatiquement si le paiement est en retard lors de la récupération
        static::retrieved(function ($payment) {
            if ($payment->isPending() && $payment->due_date->isPast()) {
                $payment->markAsLate();
            }
        });
    }

    /**
     * Obtenir la liste des méthodes de paiement disponibles.
     */
    public static function getPaymentMethods(): array
    {
        return [
            'cash' => 'Espèces',
            'wave' => 'Wave',
            'om' => 'Orange Money',
            'momo' => 'MTN Mobile Money',
            'moov' => 'Moov Money',
            'bank' => 'Virement bancaire',
        ];
    }

    /**
     * Obtenir le libellé lisible pour la méthode de paiement.
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        $methods = self::getPaymentMethods();
        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Obtenir le libellé lisible pour le statut.
     */
    public function getStatusLabelAttribute(): string
    {
        $statuses = [
            'pending' => 'En attente',
            'paid' => 'Payé',
            'late' => 'En retard',
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}

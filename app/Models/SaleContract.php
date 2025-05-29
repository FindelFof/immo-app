<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleContract extends Model
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
        'buyer_id',
        'contract_date',
        'sale_date',
        'sale_price',
        'deposit',
        'status',
        'payment_schedule',
        'notes',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contract_date' => 'date',
        'sale_date' => 'date',
        'sale_price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'payment_schedule' => 'array',
    ];

    /**
     * Obtenir la propriété concernée par ce contrat de vente.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Obtenir l'acheteur concerné par ce contrat de vente.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Générer automatiquement un numéro de contrat unique lors de la création.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            if (empty($contract->contract_number)) {
                $prefix = 'VENTE-';
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

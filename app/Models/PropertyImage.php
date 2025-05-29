<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'path',
        'is_featured',
        'display_order',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Obtenir la propriété à laquelle cette image appartient.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'postal_code',
        'address',
        'city',
        'state',
        'country',
        'street',
        'number',
        'neighborhood',
        'complement',
        'reference',
        'set_default'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

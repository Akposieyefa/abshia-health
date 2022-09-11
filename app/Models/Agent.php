<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method create(array $array)
 */
class Agent extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id', 'ref_code', 'name', 'address', 'phone_number', 'status', 'lga_id', 'slug'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enrolled_users(): HasMany
    {
        return $this->hasMany(Enrolle::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}

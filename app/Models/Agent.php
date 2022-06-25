<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $array)
 */
class Agent extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id', 'ref_code', 'name', 'address', 'phone_number', 'status', 'lga_id', 'slug'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enrolled_users(): \Illuminate\Database\Eloquent\Relations\HasMany
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

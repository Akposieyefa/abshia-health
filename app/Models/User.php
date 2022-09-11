<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Libs\Traits\UsesUuidTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method where(string $string, string $string1, $email)
 * @method create(array $array)
 * @method find($id)
 * @method findOrFail($id)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, UsesUuidTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
         'email', 'password', 'email_verified_at', 'role',  'slug'
    ];

    public function agent(): HasOne
    {
        return $this->hasOne(Agent::class);
    }

    public function hospital(): HasOne
    {
        return $this->hasOne(HealthCare::class);
    }

    public function enrollee(): HasOne
    {
        return $this->hasOne(Enrolle::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}

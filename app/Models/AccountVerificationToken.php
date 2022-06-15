<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method where(string $string, string $string1, $token)
 */
class AccountVerificationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'token'
    ];
}

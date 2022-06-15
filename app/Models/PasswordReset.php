<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $array)
 * @method where(string $string, string $string1, $email)
 */
class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'token'
    ];
    public $timestamps = false;
}

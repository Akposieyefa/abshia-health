<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method where(string $string, string $string1, $trans_ref)
 * @method create(array $array)
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrolle_id', 'trans_ref' , 'type', 'amount' , 'description',  'payment_gateway', 'status', 'plan_id'
    ];

    public function enrolle(): BelongsTo
    {
        return $this->belongsTo(Enrolle::class, 'enrolle_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

}

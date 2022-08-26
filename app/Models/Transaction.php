<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method where(string $string, string $string1, $trans_ref)
 * @method create(array $array)
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrolle_id', 'trans_ref' , 'type', 'amount' , 'description',  'payment_gateway', 'status', 'category_id'
    ];

    public function enrolle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Enrolle::class, 'enrolle_id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}

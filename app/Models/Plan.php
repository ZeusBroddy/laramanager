<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'type',
        'name',
        'stripe_plan_id',
        'stripe_product_id',
        'description',
        'amount',
        'currency',
        'interval',
    ];

    /**
     * Retorna o valor formato brl de amount
     */
    public function getAmountBrlAttribute()
    {
        return $this->amount / 100;
    }
}

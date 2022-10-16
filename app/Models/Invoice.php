<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'description',
        'total',
        'net_total',
        'stripe_id',
        'paid_at',
        'due_date'
    ];

    /**
     * Get the user from this invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Interact with the invoice's due_date.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function dueDateMonth(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('F'),
        );
    }

    /**
     * Interact with the invoice's due_date.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function dueDateFormated(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

    /**
     * Interact with the invoice's paid_at.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function paidAtFormated(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d M Y H:i'),
        );
    }

    /**
     * Interact with the invoices's net_total
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function netTotal(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value - ($value * 0.0399 + 39),
        );
    }

    /**
     * Get the amount formated to brl
     */
    public function getTotalBrlAttribute()
    {
        return number_format($this->total / 100, 2, ',', ' ');
    }
}

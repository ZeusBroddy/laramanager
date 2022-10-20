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
     * Get the due_date formated to month in portuguese
     */
    public function getDueDateMonthAttribute()
    {
        if ($this->due_date) {
            return Carbon::parse($this->due_date)->translatedFormat('F');
        }
        return null;
    }

    /**
     * Get the due_date formated in portuguese
     */
    public function getDueDateFormatedAttribute()
    {
        if ($this->due_date) {
            return Carbon::parse($this->due_date)->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get the due_date formated in portuguese
     */
    public function getPaidAtFormatedAttribute()
    {
        if ($this->paid_at) {
            return Carbon::parse($this->paid_at)->translatedFormat('d M Y H:i');
        }
        return null;
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

    /**
     * Interact with the invoices's total
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
        );
    }
}

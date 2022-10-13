<?php

namespace App\Models;

use Carbon\Carbon;
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
        'plan_id',
        'description',
        'total',
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
        return Carbon::createFromDate($this->due_date)->translatedFormat('F');
    }

    /**
     * Get the due_date formated in portuguese
     */
    public function getDueDateFormatedAttribute()
    {
        return Carbon::createFromDate($this->due_date)->format('d/m/Y');
    }

    /**
     * Get the due_date formated in portuguese
     */
    public function getPaidAtFormatedAttribute()
    {
        return Carbon::createFromDate($this->paid_at)->translatedFormat('d M Y H:i');
    }

    /**
     * Get the amount formated to brl
     */
    public function getTotalBrlAttribute()
    {
        return 'R$ '. number_format($this->total / 100, 2, ',', ' ');
    }
}

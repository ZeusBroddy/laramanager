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
        'name',
        'description',
        'amount',
    ];

    /**
     * Get the total formated to brl
     */
    public function getAmountBrlAttribute()
    {
        return 'R$ '. number_format($this->amount / 100, 2, ',', ' ');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'category_id',
        'description',
        'amount',
        'date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Retorna a data formatada
     */
    public function getDateFormatedAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->date)
            ->format('m/d/Y');
    }
}

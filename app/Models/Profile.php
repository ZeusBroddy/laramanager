<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'university_id',
        'avatar',
        'cpf',
        'birth_date',
        'address',
        'city',
        'postal_code',
        'phone_number'
    ];

    /**
     * Get the user from this profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the university from this profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function university()
    {
        return $this->belongsTo(University::class);
    }

    /**
     * Get the CPF formated
     */
    public function getCpfFormatedAttribute()
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $this->cpf);
    }

    /**
     * Get the birth_date date formated
     */
    public function getBirthDateFormatedAttribute()
    {
        return Carbon::createFromDate($this->birth_date)->translatedFormat('d M Y');
    }
}

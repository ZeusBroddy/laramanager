<?php

namespace App\Models;

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
        'avatar',
        'cpf',
        'address',
        'state',
        'city',
        'postal_code',
        'country',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retorna o CPF formatado
     */
    public function getCpfFormatedAttribute()
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $this->cpf);
    }
}

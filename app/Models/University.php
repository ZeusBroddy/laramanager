<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path_id',
        'name',
        'avatar',
        'address',
        'district',
        'city'
    ];

    public function path()
    {
        return $this->belongsTo(Path::class);
    }

    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}

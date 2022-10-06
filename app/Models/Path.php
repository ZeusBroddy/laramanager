<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the universities for the path.
     */
    public function universities()
    {
        return $this->hasMany(University::class);
    }

    /**
     * Get all of the profiles for the path.
     */
    public function profiles()
    {
        return $this->hasManyThrough(Profile::class, University::class);
    }
}

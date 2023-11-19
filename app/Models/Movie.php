<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'year',
        'title',
        'studio',
        'winner'  
    ];

    public function producers()
    {
        return $this->belongsToMany(Producer::class, 'movies_produces');
    }
}

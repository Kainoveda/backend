<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Songs extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'genre',
        'album',
        'music_file_name',
    ];

    public function artist()
    {
        return $this->belongsTo(User::class, 'artist');
    }
    
}

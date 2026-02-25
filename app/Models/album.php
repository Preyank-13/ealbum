<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
protected $fillable = [
    'studio_id',
    'album_name',
    'album_type',
    'unique_code',
    'cover_photo',
    'album_song'
];
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
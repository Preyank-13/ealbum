<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';
    protected $fillable = ['studio_id', 'images', 'status'];

    // This line fixes the TypeError in your screenshots
    protected $casts = [
        'images' => 'array',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = ['studio_id', 'images', 'status'];
    protected $casts = [
        'images' => 'array',
    ];
    // Ye images array ko database mein save karte waqt JSON bana dega

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
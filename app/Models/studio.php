<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    // Mass Assignment ki permission (user_id add kar di hai)
protected $fillable = [
    'user_id', 
    'studio_name', 
    'contact_person', 
    'studio_email', 
    'studio_contact', 
    'experience'
];
public function user()
{
    return $this->belongsTo(User::class);
}

    /**
     * Relationships: Album aur Gallery ke saath
     */
    public function album()
    {
        return $this->hasOne(Album::class);
    }

    public function gallery()
    {
        return $this->hasOne(Gallery::class);
    }
}
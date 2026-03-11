<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'business_name',
        'contact_no',
        'about',
        'address',
        'city',
        'country',
        'zip_code',
        'logo',
        'credits',
        'is_unlimited',      
        'active_plan',
        'plan_expires_at',   
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'plan_expires_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    /**
     * Relationship with Studio model
     */
    public function studios()
    {
        return $this->hasMany(Studio::class);
    }

    /**
     * Relationship with Credit model (Aapne 'Credit' naam rakha hai)
     * Isse aap user ki saari credit history fetch kar payenge.
     */
    public function creditHistory()
    {
        return $this->hasMany(Credit::class);
    }
}
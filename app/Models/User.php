<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Sweet1s\MoonshineRBAC\Traits\MoonshineRBACHasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use MoonshineRBACHasRoles;

    const SUPER_ADMIN_ROLE_ID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'phone_verified_at',
        'sms_code',
        'sms_code_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'phone_verified_at' => 'datetime',
            'sms_code_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get user's reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reserv::class, 'phone', 'phone');
    }

    /**
     * Check if SMS code is valid and not expired
     */
    public function isSmsCodeValid($code)
    {
        return $this->sms_code === $code &&
            $this->sms_code_expires_at &&
            $this->sms_code_expires_at->isFuture();
    }
}

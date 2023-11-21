<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasProfilePhoto, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'firstName',
        'lastName',
        'SecondName',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = ['profile', 'profile_photo_url'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function routeNotificationForSms ($notifiable) : string
    {
        return format_phone_no ($this->phone);
    }

    public function oneTimePassword(): HasMany
    {
        return $this->hasMany(UserOneTimePassword::class);
    }

    public function candidateProfile()
{
    return $this->hasOne(CandidateProfile::class, 'profileID', 'profileID');
}

    public function getProfileAttribute(){
        return $this->candidateProfile;
    }
}

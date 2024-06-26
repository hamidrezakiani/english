<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->api_token = Str::random(80);
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mobile','name','invitation_code','invited_by','ip','mobileVerify','new_user','payStatus','api_token'
    ];

    public function getNewUserAttribute(){
        return 0;
    }

    public function getIsPaidAttribute(){
        return intval($this->payStatus || $this->created_at > Carbon::now()->subDays(6));
    }

    public function smsVerifications()
    {
        return $this->hasMany(SmsVerification::class);
    }

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

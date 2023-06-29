<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'email',
        'password',
        'fname',
        'mname',
        'lname',
        'suffix',
        'bday',
        'address',
        'role_id',
        'profile_pic'

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'requestor_id', 'id');
    }

    public function sentNotifications()
    {
        return $this->hasMany(Notification::class, 'from', 'id');
    }

    public function receivedNotifications()
    {
        return $this->hasMany(Notification::class, 'to', 'id');
    }

    public function itemsReceived()
    {
        return $this->hasMany(ReceivedBy::class, 'received_by', 'id');
    }

    public function userFavorite()
    {
        return $this->hasMany(Favorite::class, 'favorite_item_id', 'id');
    }


}

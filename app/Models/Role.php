<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUUID;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'role',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'role_id', 'role_id');
    // }
}

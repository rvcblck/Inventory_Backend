<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'company';
    protected $primaryKey = 'company_id';
    protected $keyType = 'string';

    protected $fillable = [
        'company_name',
        'company_contact_no',
        'company_address',
        'company_info',
        'logo',


    ];

    public function user()
    {
        return $this->hasMany(User::class, 'company_id', 'company_id');
    }

    public function quantity()
    {
        return $this->hasMany(ItemQuantity::class, 'company_id', 'company_id');
    }

    public function items()
    {
        return $this->hasManyThrough(Item::class, ItemQuantity::class, 'company_id', 'item_id', 'company_id', 'item_id');
    }

    public function request()
    {
        return $this->hasMany(Request::class, 'company_id', 'company_id');
    }
}

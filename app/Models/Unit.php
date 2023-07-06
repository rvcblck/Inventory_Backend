<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'units';
    protected $primaryKey = 'unit_id';
    protected $keyType = 'string';

    protected $fillable = [
        'type',
        'unit',
        'shorthand'
    ];


    public function items()
    {
        return $this->hasMany(Item::class, 'unit_id', 'unit_id');
    }
}

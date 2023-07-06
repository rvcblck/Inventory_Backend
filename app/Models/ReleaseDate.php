<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseDate extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'release_date';
    protected $primaryKey = 'release_date_id';
    protected $keyType = 'string';

    protected $fillable = [
        'order_list_id',
        'status',
        'quantity',
        'release_date',
        'receive_date',
        'is_checked_warehouse',
        'archived',


    ];
}

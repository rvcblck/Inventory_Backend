<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestList extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'request_list';
    protected $primaryKey = 'request_list_id';
    protected $keyType = 'string';

    protected $fillable = [
        'request_id',
        'item_id',
        'status',
        'request_quantity',
        'request_approved',
        'request_disapproved',
        'archived',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'request_quantity' => 'float',
        'request_approved' => 'float',
        'request_disapproved' => 'float',

    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }
}

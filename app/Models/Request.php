<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'request';
    protected $primaryKey = 'request_id';
    protected $keyType = 'string';

    protected $fillable = [
        'request_number',
        'qr_code',
        'from',
        'to',
        'from_message',
        'to_message',
        'archived'


    ];

    public function requestList()
    {
        return $this->hasMany(RequestList::class, 'request_id', 'request_id');
    }
}

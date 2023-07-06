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
        'company_id',
        'request_number',
        'qr_code',
        'requestor_id',
        'message',
        'date_needed',
        'transaction_type',
        'admin_checked',
        'archived',



    ];

    protected $casts = [
        'date_needed' => 'datetime',

    ];

    public function requestList()
    {
        return $this->hasMany(RequestList::class, 'request_id', 'request_id');
    }

    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}

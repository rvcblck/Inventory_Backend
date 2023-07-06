<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $keyType = 'string';

    protected $fillable = [
        'order_number',
        'company_id',
        'qr_code',
        'request_id',
        'supplier_id',
        'delivery_location',
        'transaction_type',
        'date_needed',
        'order_total_price',
        'is_bidding',
        'bidding_start',
        'bidding_end',
        'archived',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'date',
        'date_delivered' => 'date',
        'date_needed' => 'date',

    ];


    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id', 'id');
    }

    public function orderList()
    {
        return $this->hasMany(OrderList::class, 'order_id', 'order_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'order_id', 'order_id');
    }

    public function supplier()
    {
        return $this->hasMany(User::class, 'supplier_id', 'id');
    }
}

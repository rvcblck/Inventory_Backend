<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'bid';
    protected $primaryKey = 'bid_id';
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'supplier_id',
        'total_bid_price',
        'is_admin_proposed',
        'is_selected_bidder',
        'archived'


    ];
}

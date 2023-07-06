<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidList extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'bid_list';
    protected $primaryKey = 'bid_list_id';
    protected $keyType = 'string';

    protected $fillable = [
        'bid_id',
        'order_list_id',
        'price_per_item',
        'total_price',
        'archived'


    ];
}

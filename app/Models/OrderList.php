<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'order_list';
    protected $primaryKey = 'order_list_id';
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'item_id',
        'status',
        'order_quantity',
        'order_completed',
        'price_per_item',
        'archived'

    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order_quantity' => 'integer',
        'order_price' => 'float',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'order_item', 'item_id');
    }
}

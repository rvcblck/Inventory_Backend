<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'restocks';
    protected $primaryKey = 'restock_id';
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'company_id',
        'item_id',
        'current_item_quantity',
        'added_item_quantity',
        'total_item',
        'date_added',
        'archived'


    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'current_item_quantity' => 'integer',
        'added_item_quantity' => 'integer',
        'total_item' => 'integer',
        'restock_amount' => 'float',
        'date_added' => 'date',
    ];


    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}

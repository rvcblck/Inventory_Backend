<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    use HasFactory;

    protected $table = 'items_return';
    protected $primaryKey = 'item_return_id';
    protected $keyType = 'string';

    protected $fillable = [
        'item_return_id',
        'return_id',
        'item_id',
        'item_return_quantity',
    ];

    public function return()
    {
        return $this->belongsTo(RequestorItemReturn::class, 'return_id', 'return_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

}

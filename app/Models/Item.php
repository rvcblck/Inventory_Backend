<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'items';
    protected $primaryKey = 'item_id';
    protected $keyType = 'string';

    protected $fillable = [
        'item_name',
        'item_description',
        'item_price',
        'item_quantity',
        'unit_id',
        'item_image',
        'category_id',
        'supplier_id',


    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'item_price' => 'float',
        'item_quantity' => 'integer',

    ];



    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function quantity()
    {
        return $this->hasMany(ItemQuantity::class, 'item_id', 'item_id');
    }

    public function restocks()
    {
        return $this->hasMany(Restock::class, 'item_id', 'item_id');
    }

    public function receivedBy()
    {
        return $this->hasMany(ReceivedBy::class, 'item_id', 'item_id');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'item_id', 'item_id');
    }

    public function company()
    {
        return $this->hasManyThrough(Company::class, ItemQuantity::class, 'item_id', 'company_id', 'item_id', 'company_id');
    }
}

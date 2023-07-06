<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemQuantity extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'item_quantity';
    protected $primaryKey = 'item_quantity_id';
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'item_id',
        'item_quantity',
    ];


    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}

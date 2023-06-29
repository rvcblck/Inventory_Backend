<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory,HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'suppliers';
     protected $primaryKey = 'supplier_id';
     protected $keyType = 'string';

     protected $fillable = [
         'item_id',
         'supplier',
         'date_supplied',


     ];


     /**
      * The attributes that should be cast.
      *
      * @var array<string, string>
      */
     protected $casts = [
        'date_supplied' => 'date',
     ];

     public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

}

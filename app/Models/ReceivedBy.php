<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedBy extends Model
{
    use HasFactory,HasUUID;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'received_by';
     protected $primaryKey = 'receive_by_id';
     protected $keyType = 'string';

     protected $fillable = [
         'item_id',
         'received_by',
         'date_received'
     ];


     /**
      * The attributes that should be cast.
      *
      * @var array<string, string>
      */
     protected $casts = [
        'date_received' => 'date',
     ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function receivedByUser()
    {
        return $this->belongsTo(User::class, 'received_by', 'id');
    }



}

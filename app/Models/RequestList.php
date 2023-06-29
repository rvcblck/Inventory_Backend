<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestList extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'request_list';
     protected $primaryKey = 'request_list_id';
     protected $keyType = 'string';

     protected $fillable = [
         'request_id',
         'item_id',
         'status',
         'request_quantity',
         'request_approved',
         'request_disapproved'


     ];


     /**
      * The attributes that should be cast.
      *
      * @var array<string, string>
      */
     protected $casts = [
        'request_quantity' => 'integer',
        'request_approved' => 'integer',
        'request_disapproved' => 'integer',

     ];

     public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }
}

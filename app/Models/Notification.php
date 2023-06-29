<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'nofications';
     protected $primaryKey = 'notification_id';
     protected $keyType = 'string';

     protected $fillable = [
         'title',
         'message',
         'from',
         'to',
         'request_id',
         'order_id',
         'type'

     ];


     /**
      * The attributes that should be cast.
      *
      * @var array<string, string>
      */


    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

}

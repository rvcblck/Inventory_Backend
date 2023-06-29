<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory, HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'favorite_items';
     protected $primaryKey = 'favorite_item_id';
     protected $keyType = 'string';

     protected $fillable = [
         'user_id',
         'item_id',


     ];


     /**
      * The attributes that should be cast.
      *
      * @var array<string, string>
      */

    public function userFavorite()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function itemFavorite()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }


}

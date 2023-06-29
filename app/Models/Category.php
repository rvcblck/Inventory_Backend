<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'categories';
     protected $primaryKey = 'category_id';
     protected $keyType = 'string';

     protected $fillable = [
         'category',
     ];


     public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'category_id');
    }
}

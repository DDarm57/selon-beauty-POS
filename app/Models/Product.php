<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
      'name',
      'code',
      'price',
      'agent_price',
      'discount',
      'stock',
      'image',
   ];

   protected $dates = [
      'deleted_at',
   ];

   public function categories()
   {
      return $this->belongsToMany(Category::class, 'product_category');
   }

   public function stocks()
   {
      return $this->hasMany(Stock::class);
   }
}

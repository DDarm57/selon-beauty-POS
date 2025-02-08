<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
      'name',
      'slug',
   ];

   protected $date = [
      'deleted_at'
   ];

   public function products()
   {
      return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
   }
}

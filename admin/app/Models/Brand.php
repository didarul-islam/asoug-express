<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
     protected $fillable = ['name', 'arabic_name', 'category_id', 'commision', 'slug', 'image'];


     public function category() {
        return $this->belongsTo(Category::class);
    }
}

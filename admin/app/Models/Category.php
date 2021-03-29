<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'arabic_name', 'parent_id', 'commision', 'slug', 'image'];

    public function parent(){
        return $this->belongsTo('App\Models\Category', 'parent_id', 'id');
    }

}

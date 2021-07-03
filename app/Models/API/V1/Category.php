<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='categories';
    protected $fillable=['name','thumb_nail'];
    
    public function products()
    {
       return $this->hasMany('App\Models\API\V1\Product');
    }
}

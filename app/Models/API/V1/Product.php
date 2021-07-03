<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table='products';
    protected $fillable=['name','thumb_nail','description','monthly_rent','refundable_deposit','size','discount','positive_rated','negative_rated','category_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\API\V1\Category');
    }
    
    public function rating()
    {
       return $this->hasMany('App\Models\API\V1\Rating');
    }
}

<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table='ratings';
    protected $fillable=['comments','rating','product_id'];

    public function product()
    {
        return $this->belongsTo('App\Models\API\V1\Product','product_id');
    }
}

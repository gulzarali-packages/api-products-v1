<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rating=$this->calculateRating($this->rating);

        return [
            'name'=>$this->name,
            'thumb_nail'=>($this->thumb_nail != '')?url('/images/products/'.$this->thumb_nail):'',
            'description'=>$this->description,
            'monthly_rent'=>'$'.$this->monthly_rent.' /Month',
            'refundable_deposit'=>'$'.$this->refundable_deposit,
            'size'=>$this->size,
            'discount'=>$this->discount,
            'rating'=> $rating,
            'category_id'=>$this->category_id
        ];
    }

    protected function calculateRating($ratings){
        
        $total_rating=0;
        $count_rating=0;
        foreach ($ratings as $rat) {
            $total_rating += $rat->rating;
            $count_rating ++;
        }

        if($count_rating == 0){
            return 0;
        }

        $product_rating = $total_rating / $count_rating;
        return  $product_rating;
    }
}

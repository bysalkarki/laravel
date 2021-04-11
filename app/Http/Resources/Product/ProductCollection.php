<?php

namespace App\Http\Resources\product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends  JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'title'=>$this->title,
            'description'=>$this->detail,
            'price'=>$this->price,
            'discountAmount'=>$this->discount,
            'discountedPrice'=>$this->price - $this->discount,
            'href'=>route('product.show',$this->id)
        ];
    }
}

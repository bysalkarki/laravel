<?php

namespace App\Http\Resources\product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->title,
            'description'=>$this->detail,
            'price'=>$this->price,
            'discountAmount'=>$this->discount,
            'discountedPrice'=>$this->price - $this->discount,
            'stock'=>$this->stock ?: 'Out of Stock',
            'star'=>round($this->reviews()->sum('star')/$this->reviews()->count(),2),


        ];
    }
}

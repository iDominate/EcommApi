<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    /**
     *    "first_page_url" => "http://ecomm.com/api/auth/category?page=1"
    "from" => 1
    "last_page" => 2
    "last_page_url" => "http://ecomm.com/api/auth/category?page=2"
    "links" => array:4 [
      0 => array:3 [
        "url" => null
        "label" => "&laquo; Previous"
        "active" => false
      ]
      1 => array:3 [
        "url" => "http://ecomm.com/api/auth/category?page=1"
        "label" => "1"
        "active" => true
      ]
      2 => array:3 [
        "url" => "http://ecomm.com/api/auth/category?page=2"
        "label" => "2"
        "active" => false
      ]
      3 => array:3 [
        "url" => "http://ecomm.com/api/auth/category?page=2"
        "label" => "Next &raquo;"
        "active" => false
      ]
    ]
    "next_page_url" => "http://ecomm.com/api/auth/category?page=2"
    "path" => "http://ecomm.com/api/auth/category"
    "per_page" => 5
    "prev_page_url" => null
    "to" => 5
    "total" => 10
     */
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        return parent::toArray($request);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserCategoryResource;
use App\Http\Resources\UserSourceResource;
use App\Http\Resources\UserAuthorResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

               
       return [
                'id' => $this->id,
                'name' => $this->name,
                'email'=>$this->email,
                //'category'=> new UserCategoryResource($this->id),
                //'source'=> new UserSourceResource($this->id),
               // 'author'=> new UserAuthorResource($this->id),
                
                ];
    }
}
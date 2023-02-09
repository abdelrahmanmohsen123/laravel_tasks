<?php

namespace App\Http\Resources\Api;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            "id"=>$this->id,
            "name" =>$this->name,
            "description" =>$this->description,
            'user'=> new UserResource($this->User) ? new UserResource($this->User) : null,
            // "user"=> $this->User->name ? $this->User->name : null,
            "post_creator"=> new UserResource($this->User) ? new UserResource($this->User) : null,
        ];

    }
}
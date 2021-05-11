<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            "id"          => $this->id,
            "author_name" => $this->author_name,
            "content"     => $this->content,
            "description" => $this->description,
            "user_id"     => $this->user_id,
            "created_at"  => $this->created_at->diffForHumans(),
        ];
    }
}

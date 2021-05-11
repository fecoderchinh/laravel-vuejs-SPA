<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            "id" => $this->id,
            "title" => $this->title,
            "slug"  => $this->slug,
            "description" => $this->description,
            "content" => $this->content,
            "category" => new CategoryResource($this->category),
            "online" => !! $this->online,
            "creator" => $this->creator,
            "cover_path" => $this->cover_path,
            "visits_count" => $this->visits,
            "comments" => CommentResource::collection($this->whenLoaded("comments")),
            "tags" => TagResource::collection($this->tags()->get())
        ];
    }
}

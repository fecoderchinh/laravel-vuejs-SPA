<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'img' => $this->photo_url,
            'roles' => RoleResource::collection($this->roles()->get()),
            'permissions' => PermissionResource::collection($this->permissions()->get()),
            "created_at"  => $this->created_at->diffForHumans(),
            "updated_at"  => $this->updated_at->diffForHumans()
        ];
    }
}

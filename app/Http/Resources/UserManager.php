<?php

namespace UserManager\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserManager extends JsonResource
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
            'phone' => $this->phone,
            'status' => $this->status,
            'gender' => $this->gender,
            'created_at' => $this->created_at->format('Y/m/d')
        ];
    }
}

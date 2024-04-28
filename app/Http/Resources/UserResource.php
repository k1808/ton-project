<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "userId"=>$this->id,
            "phone"=>$this->phone,
            "firstName"=>$this->firstName,
            "lastName"=>$this->lastName,
            "link"=>$this->link,
            "userType"=>$this->role->name,
            "isAuth"=>$this->isAuth>0?true:false

        ];
    }
}

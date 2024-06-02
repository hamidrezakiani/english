<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'api_token' => $this->api_token,
            'mobile'    => $this->mobile,
            'payStatus' => intval($this->payStatus),
            'new_user' => intval($this->new_user),
            'verify'  => intval($this->mobileVerify)
        ];
    }
}

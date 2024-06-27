<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Service;
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
        $amount = Service::where('type','SUBSCRIPTION')->first()->amount;
        return [
            'name' => $this->name,
            'api_token' => $this->api_token,
            'mobile'    => $this->mobile,
            'payStatus' => $this->isPaid,
            'new_user' => intval($this->new_user),
            'verify'  => intval($this->mobileVerify),
            'amount'  => $amount
        ];
    }
}

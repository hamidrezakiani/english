<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Service;
class ProfileResource extends JsonResource
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
            'payStatus' => intval($this->payStatus),
            'new_user' => intval($this->new_user),
            'verify'  => intval($this->mobileVerify),
            'amount'  => $amount
        ];
    }
}

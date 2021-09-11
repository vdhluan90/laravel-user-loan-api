<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'access_token' => $this->resource->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $this->resource->token->expires_at,
        ];
    }
}

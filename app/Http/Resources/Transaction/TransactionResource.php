<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'id' => $this->resource->id,
            'note' => $this->resource->note,
            'amount' => $this->resource->amount,
            'penalty_amount' => $this->resource->penalty_amount,
            'type' => $this->resource->type,
            'is_overdue' => $this->resource->is_overdue,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}

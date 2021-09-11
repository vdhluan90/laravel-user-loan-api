<?php

namespace App\Http\Resources\LoanPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanPlanResource extends JsonResource
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
            'description' => $this->resource->description,
            'months' => $this->resource->months,
            'interest_percentage' => $this->resource->interest_percentage,
            'penalty_rate' => $this->resource->penalty_rate,
            'created_at' => strtotime($this->resource->created_at),
            'updated_at' => strtotime($this->resource->updated_at),
        ];
    }
}

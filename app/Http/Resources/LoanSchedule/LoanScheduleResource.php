<?php

namespace App\Http\Resources\LoanSchedule;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanScheduleResource extends JsonResource
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
            'loan_schedule_id' => $this->resource->id,
            'loan_id' => $this->resource->loan_id,
            'amount' => $this->resource->amount,
            'status' => $this->resource->status,
            'due_date' => $this->resource->due_date,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}

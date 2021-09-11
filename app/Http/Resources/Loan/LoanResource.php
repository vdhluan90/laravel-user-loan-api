<?php

namespace App\Http\Resources\Loan;

use App\Http\Resources\LoanSchedule\LoanScheduleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->resource->id,
            'purpose' => $this->resource->purpose,
            'amount' => $this->resource->amount,
            'due_date' => $this->resource->due_date,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'loan_schedules' => [],
        ];

        if (isset($this->loanSchedules)) {
            foreach ($this->loanSchedules as $loanSchedule) {
                $result['loan_schedules'][] = new LoanScheduleResource($loanSchedule);
            }
        }

        return $result;
    }
}

<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class LoanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $action = Route::current()->getAction();
        $actionName = $action['as'];

        switch ($actionName) {
            case 'loans.create':
                return $this->rulesCreate();
            default:
                return [];
        }
    }

    public function rulesCreate()
    {
        return [
            'purpose' => 'string',
            'amount' => 'required|numeric|min:1',
            'loan_plan_id' => 'required|integer',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

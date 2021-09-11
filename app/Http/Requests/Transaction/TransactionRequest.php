<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class TransactionRequest extends FormRequest
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
            case 'transactions.create':
                return $this->rulesCreate();
            default:
                return [];
        }
    }

    public function rulesCreate()
    {
        return [
            'note' => 'string',
            'amount' => 'required|numeric|min:1',
            'penalty_amount' => 'numeric|min:1',
            'type' => 'required|string|in:monthly,settlement',
            'loan_id' => 'required|integer',
            'loan_schedule_id' => 'integer',
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

<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\Loan\LoanRequest;
use App\Http\Resources\Loan\LoanResource;
use App\Managers\LoanManager;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;

class LoanController extends ApiController
{
    /** @var LoanManager */
    private $manager;

    /**
     * LoanController constructor.
     *
     * @param LoanManager $manager
     */
    public function __construct(LoanManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function get($id): JsonResponse
    {
        return response()->json(new LoanResource(Loan::with('loanSchedules')->findOrFail($id)));
    }

    /**
     * @param LoanRequest $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(LoanRequest $request): JsonResponse
    {
        $this->manager->create($request->all(), Auth::user());

        return $this->respondCreated();
    }
}

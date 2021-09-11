<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\TransactionRequest;
use Auth;
use App\Managers\TransactionManager;
use Illuminate\Http\JsonResponse;

class TransactionController extends ApiController
{
    /** @var TransactionManager */
    private $manager;

    /**
     * TransactionController constructor.
     *
     * @param TransactionManager $manager
     */
    public function __construct(TransactionManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param TransactionRequest $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(TransactionRequest $request): JsonResponse
    {
        $this->manager->create($request->all(), Auth::user());

        return $this->respondCreated();
    }
}

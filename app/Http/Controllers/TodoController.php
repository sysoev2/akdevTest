<?php

namespace App\Http\Controllers;

use App\Factories\TodoDTOFactory;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\TodoList;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TodoController extends ApiController
{
    public function __construct
    (
        private TodoService $todoService
    )
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request): JsonResponse
    {
        $dto = TodoDTOFactory::fromRequest($request);
        $this->authorize('create', [Todo::class, $dto]);
        return $this->successResponse($this->todoService->store($dto));
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo): JsonResponse
    {
        $this->authorize('view', $todo);
        return $this->successResponse($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, Todo $todo): JsonResponse
    {
        $this->authorize('update', $todo);
        $dto = TodoDTOFactory::fromRequest($request);
        return $this->successResponse($this->todoService->update($todo,$dto));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $this->authorize('delete', $todo);
        if($this->todoService->delete($todo)) {
            return $this->successResponse(message: 'successfully deleted');
        }
        return $this->errorResponse(message: 'unsuccessful deletion');
    }
}

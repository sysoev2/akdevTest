<?php

namespace App\Http\Controllers;

use App\Factories\TodoListDTOFactory;
use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use App\Services\TodoListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TodoListController extends ApiController
{
    public function __construct(
        private TodoListService $todoListService
    )
    {
        $this->authorizeResource(TodoList::class, 'todoList');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $todoLists = TodoList::whereRelation('users', 'id', Auth::id())->get()->all();
        return $this->successResponse($todoLists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoListRequest $request): JsonResponse
    {
        $dto = TodoListDTOFactory::fromRequest($request);
        return $this->successResponse($this->todoListService->store($dto));
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoList $todoList): JsonResponse
    {
        return $this->successResponse($todoList);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoListRequest $request, TodoList $todoList): JsonResponse
    {
        $dto = TodoListDTOFactory::fromRequest($request);
        return $this->successResponse($this->todoListService->update($todoList, $dto));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoList $todoList): JsonResponse
    {
        $deleted = $this->todoListService->delete($todoList);
        if($deleted) {
            return $this->successResponse(message: 'successfully deleted');
        }
        return $this->errorResponse(message: 'unsuccessful deletion');
    }
}

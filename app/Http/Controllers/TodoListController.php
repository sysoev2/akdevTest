<?php

namespace App\Http\Controllers;

use App\Factories\TodoListDTOFactory;
use App\Http\Requests\TodoListRequest;
use App\Jobs\GenerateTodoPDF;
use App\Mail\TodoListMail;
use App\Models\TodoList;
use App\Services\TodoListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
     * Display todos of todoList.
     */
    public function showTodos(TodoList $todoList): JsonResponse
    {
        $this->authorize('view', $todoList);
        return $this->successResponse($todoList->todos);
    }

    public function exportPDF(TodoList $todoList): JsonResponse
    {
        $mail = Mail::to(Auth::user()->email)->send(new TodoListMail($todoList));
        if($mail) {
            return $this->successResponse(message: 'Mail sent');
        }
        return $this->successResponse(message: 'Mail did not send');
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

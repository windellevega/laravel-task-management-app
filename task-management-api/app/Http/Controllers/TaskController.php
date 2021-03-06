<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::where('assigned_to_id', Auth::id())
                    ->with('creator')
                    ->with('worker')
                    ->get();
        $tasks->load('checklists.statusHistory');

        return response()->json($tasks, 200);
            
    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $task = Task::create([
            'title'             => $request->title,
            'user_id'           => Auth::id(),
            'assigned_to_id'    => $request->assigned_to_id
        ]);

        return response()->json($task, 201);
    }

    public function show(Task $task): JsonResponse
    {
        if($task->user_id != Auth::id() && $task->assigned_to_id != Auth::id()){
            abort(403);
        }
        $task->load(['creator', 'worker', 'checklists.statusHistory']);

        return response()->json($task, 200);
    }

    public function update(TaskStoreRequest $request, Task $task): JsonResponse
    {
        if($task->user_id != Auth::id()){
            abort(403);
        }

        $task->update($request->validated());

        return response()->json($task, 200);
    }

    public function destroy(Task $task): JsonResponse
    {
        if($task->user_id != Auth::id()){
            abort(403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task has been deleted.'
        ], 200);
    }
}

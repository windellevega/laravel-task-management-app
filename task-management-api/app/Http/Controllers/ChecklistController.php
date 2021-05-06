<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChecklistStoreRequest;
use App\Http\Requests\TaskStatusUpdateRequest;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function store(ChecklistStoreRequest $request) : JsonResponse
    {
        $task = Task::find($request->task_id);
        if ($task->user_id != Auth::id() && $task->assigned_to_id != Auth::id()) {
            abort(401);
        }

        $checklist = Checklist::create($request->validated());
        $checklist->statusHistory()->attach(1, ['remarks' => 'Checklist has been created.']);

        return response()->json($checklist->load('statusHistory'), 201);
    }

    public function update(ChecklistStoreRequest $request, Checklist $checklist) : JsonResponse
    {
        if ($checklist->task->user_id != Auth::id() && $checklist->task->asisiged_to_id != Auth::id()) {
            abort(401);
        }

        $checklist->update($request->validated());

        return response()->json($checklist, 200);
    }

    public function updateStatus(TaskStatusUpdateRequest $request, Checklist $checklist)
    {
        if ($checklist->task->assigned_to_id != Auth::id()) {
            abort(401);
        }

        $checklist->statusHistory()->attach($request->status_id, ['remarks' => $request->remarks]);

        return response()->json($checklist->load('statusHistory'), 200);
    }

    public function destroy(Checklist $checklist) : JsonResponse
    {
        if ($checklist->task->user_id != Auth::id()) {
            abort(401);
        }

        $checklist->delete();

        return response()->json([
            'message' => 'Checklist has been deleted.'
        ], 200);
    }
}

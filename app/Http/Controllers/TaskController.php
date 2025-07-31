<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Validation\ValidationException; 
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException; 

class TaskController extends Controller
{
    /**
     * Create new user task
     * POST /api/task
     * Input: title, description(optional)
     * Output: 201, task data
     */
    public function store(Request $request) {
        $userData = auth()->user();

        // input validation
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',     
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }

        // create task
        $task = $userData->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false, 
        ]);

        return response()->json($task, 201); 
    }

    /**
     * List all user task
     * GET /api/task
     * Output: 200, list of task
     */
    public function list(Request $request) {
        $userData = auth()->user();


        // get all user's tasks
        $tasks = $userData->tasks()->get();

        return response()->json($tasks, 200); 
    }

    /**
     * Delete a user's task based on id
     * DELETE /api/task/{task}
     * Output: 200, message
     */
    public function destroy(Request $request, Task $task) {
        $userData = auth()->user();

        // task and user validation
        if ($task->user_id !== $userData->id) {
            return response()->json([
                'message' => 'Forbidden: You do not have access to this task',
            ], 403); // 
        }

        // delete task
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }

    /**
     * Update user's task based on id params
     * PUT /api/task/{task}
     * Output: 200, updated task
     */
    public function update(Request $request, Task $task) {
        $userData = auth()->user();


        // task and user validation
        if ($task->user_id !== $userData->id) {
            return response()->json([
                'message' => 'Forbidden: You do not have access to this task',
            ], 403); // 
        }

        // validate input
        try {
            $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string', 
                'completed' => 'sometimes|boolean',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }

        // update task with only provided data
        $task->update($request->all());


        return response()->json($task, 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //devuelve el listado de tareas del modelo Task
        return TaskCollection::make(Task::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getTaskByStatus($status)
    {
        if ($status == 'todo') {
            $status = TaskStatus::Todo;
        } elseif ($status == 'doing') {
            $status = TaskStatus::Doing;
        } elseif ($status == 'done') {
            $status = TaskStatus::Done;
        } else {
            return response()->json(['error' => 'Invalid status'], 400);
        }

        //devuelve el listado de tareas del modelo Task
        return TaskCollection::make(Task::where('status', $status)->get());

    }

    /**
     * Display the specified resource.
     */
    public function show($task)
    {
        //busca la tarea por id
        $task = Task::find($task);

        //valida que la tarea exista
        if (is_null($task)) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        //devuelve la tarea solicitada
        return TaskResource::make($task);
    }

}

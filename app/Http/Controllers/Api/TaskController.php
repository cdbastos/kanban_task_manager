<?php

namespace App\Http\Controllers\Api;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
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
        //busca el status dentro del enum TaskStatus
        try {
            $statusEnum = TaskStatus::from($status);
        } catch (\Exception $e) {
            // Si el valor de $status no es válido, devuelve un error
            return response()->json(['error' => 'Invalid status'], 400);
        }

        //devuelve el listado de tareas del modelo Task
        return response()->json(Task::where('status', $status)->get());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //devuelve la tarea solicitada
        return TaskResource::make($task);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

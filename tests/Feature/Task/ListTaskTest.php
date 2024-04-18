<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use Carbon\Carbon;
use Tests\TestCase;

class ListTaskTest extends TestCase
{

    /** @test */
    public function can_fetch_a_single_task(): void
    {

        $task = Task::factory()->create();

        $response = $this->getJson(route('api.v1.tasks.show', $task));

        $response->assertExactJson([
            'data' => [
                'type' => 'tasks',
                'id' => (string)$task->getRouteKey(),
                'attributes' => [
                    'user_id' => $task->user_id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $task->status,
                    'urgent' => (bool)$task->urgent,
                    'progress' => $task->progress,
                    'due_date' => Carbon::parse($task->due_date)->format('Y-m-d H:i'),
                ],
                'links' => [
                    'self' => route('api.v1.tasks.show', $task),
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_task()
    {
        $tasks = Task::all();

        $response = $this->getJson(route('api.v1.tasks.index'));

        //itera sobre las tareas y las guarda en un array
        $data = [];
        foreach ($tasks as $item) {
            $data[] = [
                'data' => [
                    'type' => 'tasks',
                    'id' => (string)$item->getRouteKey(),
                    'attributes' => [
                        'user_id' => $item->user_id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'status' => $item->status,
                        'urgent' => (bool)$item->urgent,
                        'progress' => $item->progress,
                        'due_date' => Carbon::parse($item->due_date)->format('Y-m-d H:i'),
                    ],
                    'links' => [
                        'self' => route('api.v1.tasks.show', $item),
                    ]
                ]
            ];
        }

        $response->assertExactJson([
            'data' => $data,
            'links' => [
                'self' => route('api.v1.tasks.index'),
            ]
        ]);
    }

    /** @test */
    public function can_fetch_task_by_status()
    {

        $response = $this->getJson(route('api.v1.tasks.status', 'doing'));

        $tasks = Task::where('status', 'Haciendo')->get();

        //itera sobre las tareas y las guarda en un array
        $data = [];
        foreach ($tasks as $item) {
            $data[] = [
                'data' => [
                    'type' => 'tasks',
                    'id' => (string)$item->getRouteKey(),
                    'attributes' => [
                        'user_id' => $item->user_id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'status' => $item->status,
                        'urgent' => (bool)$item->urgent,
                        'progress' => $item->progress,
                        'due_date' => Carbon::parse($item->due_date)->format('Y-m-d H:i'),
                    ],
                    'links' => [
                        'self' => route('api.v1.tasks.show', $item),
                    ]
                ]
            ];
        }

        $response->assertExactJson([
            'data' => $data,
            'links' => [
                'self' => route('api.v1.tasks.index'),
            ]
        ]);

    }
}

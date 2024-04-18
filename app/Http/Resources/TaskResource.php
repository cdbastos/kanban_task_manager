<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'type' => 'tasks',
                'id' => (string) $this->resource->getRouteKey(),
                'attributes' => [
                    'user_id' => $this->resource->user_id,
                    'title' => $this->resource->title,
                    'description' => $this->resource->description,
                    'status' => $this->resource->status,
                    'urgent' => (bool)$this->resource->urgent,
                    'progress' => $this->resource->progress,
                    //fecha
                    'due_date' => Carbon::parse($this->resource->due_date)->format('Y-m-d H:i'),
                ],
                'links' => [
                    'self' => route('api.v1.tasks.show', $this->resource->getRouteKey()),
                ]
            ]
        ];
    }
}

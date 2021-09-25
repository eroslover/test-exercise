<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompilationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $exercises = $this->exercises->map(function ($exercise) {
            return [
                'id' => $exercise->id,
                'title' => $exercise->title,
                'description' => $exercise->description,
                'category_id' => $exercise->category_id,
                'category_title' => $exercise->category->title,
                'status' => $exercise->pivot->status,
            ];
        });

        return [
            'id' => $this->id,
            'title' => $this->title,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'exercises' => $exercises
        ];
    }
}

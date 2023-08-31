<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'poster' => $this->poster_path,
            'banner' => $this->banner_path,
            'type' => $this->type,
            'release_date' => $this->release_date,
            'vote' => $this->vote,
            'vote_count' => $this->vote_count,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),

        ];
    }
}

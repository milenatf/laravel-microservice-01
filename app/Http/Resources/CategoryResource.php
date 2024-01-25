<?php

namespace App\Http\Resources;

use Carbon\Carbon; // Biblioteca default do laravel que formata a data
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->url,
            'description' => $this->description,
            'date_created' => Carbon::make($this->created_at)->format('d/m/Y')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'desc' => $this->desc,
            'title' => $this->title,
            'begin' => $this->begin,
            'end' => $this->end,
            'location' => $this->location,
            'link' => $this->link,
            'color' => $this->association->color,
            'associationName' => $this->association->name,
        ];
    }
}

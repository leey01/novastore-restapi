<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $pf_item = Storage::disk('public')->url($this->pf_item);
        return [
            'id' => $this->id,
            'game_id' => $this->game_id,
            'item' => $this->item,
            'price' => $this->price,
            'pf_item' => $pf_item,
        ];
    }
}

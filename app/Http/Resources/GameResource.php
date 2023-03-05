<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pf_thumbnail = Storage::disk('public')->url($this->pf_thumbnail);

        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'pengembang' => $this->pengembang,
            'deskripsi' => $this->deskripsi,
            'genre' => $this->genre,
            'pf_thumbnail' => $pf_thumbnail,
            'platform' => $this->platform,
        ];
    }
}

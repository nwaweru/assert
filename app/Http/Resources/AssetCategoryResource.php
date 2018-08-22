<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetCategoryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $log = '';

        if ($this->created_at->toDateTimeString() === $this->updated_at->toDateTimeString()) {
            $log = 'Created on ' . $this->created_at->format('jS F Y @ g:i a');
        } else {
            $log = 'Updated on ' . $this->updated_at->format('jS F Y @ g:i a');
        }

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'log' => $log,
        ];
    }
}

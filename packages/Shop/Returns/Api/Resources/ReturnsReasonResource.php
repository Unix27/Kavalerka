<?php


namespace Shop\Returns\Api\Resources;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnsReasonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            'name' => $this->name,
        ];
    }
}

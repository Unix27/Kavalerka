<?php


namespace Localization\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class LocaleTableResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'sort' => $this->sort,
            'active' => $this->active,
            'regional' => $this->regional,
            'script' => $this->script,
            'native' => $this->native,
            'default' => $this->default,
            'is_visible_site' => $this->is_visible_site,
        ];
    }
}

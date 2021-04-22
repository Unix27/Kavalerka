<?php

namespace Core\Settings\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'left_symbol' => $this->left_symbol,
            'right_symbol' => $this->right_symbol,
            'number_symbol_comma' => $this->number_symbol_comma,
            'value' => $this->value,
            'default' => $this->default,
            'active' => $this->active,
            'updated_at' => $this->updated_at
        ];
    }
}

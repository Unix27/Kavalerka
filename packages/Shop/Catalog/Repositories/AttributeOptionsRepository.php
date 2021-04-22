<?php


namespace Shop\Catalog\Repositories;


use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\AttributeOption;
use Shop\Catalog\Models\AttributeOptionTranslation;

class AttributeOptionsRepository
{
    protected $locale;

    public function __construct()
    {
        $this->locale = request()->input('locale') ?? app()->getLocale();
    }

    public function syncOptions(Attribute $attribute, array $options)
    {
        //dd($options);

        foreach ($options as $option) {

            $existsOption = AttributeOptionTranslation::where('title', $option['option'])
                ->where('locale', $this->locale)
                ->first();

            if($existsOption) continue;

            $optionModel = new AttributeOption();
            $optionModel->attribute_id = $attribute->id;
            $optionModel->save();

            $optionModel->translateOrNew($this->locale)->title = $option['option'];
            $optionModel->save();

        }
    }
}

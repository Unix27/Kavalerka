<?php


namespace Shop\Catalog\Repositories;


use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\Product;

class AttributesRepository
{
    protected $attributeOptionsRepository;
    protected $locale;

    public function __construct()
    {
        $this->attributeOptionsRepository = app(AttributeOptionsRepository::class);
        $this->locale = request()->input('locale') ?? app()->getLocale();
    }

    public function create(array $atts)
    {
        $attribute = Attribute::create($atts);
        $attribute->translateOrNew(app()->getLocale())->fill($atts);
        $attribute->save();

//        if(
//            ($atts['type'] == 'select' || $atts['type'] == 'multiselect' ) &&
//            isset($atts['options'])
//        ) {
//            $this->attributeOptionsRepository->syncOptions($attribute, $atts['options']);
//        }

        return $attribute;
    }

    public function update(Attribute $attribute, array $atts)
    {
        $attribute->update($atts);
        $attribute->translateOrNew(app()->getLocale())->fill($atts);
        $attribute->save();

//        if(
//            ($atts['type'] == 'select' || $atts['type'] == 'multiselect' ) &&
//            isset($atts['options'])
//        ) {
//            $this->attributeOptionsRepository->syncOptions($attribute, $atts['options']);
//        }

        return $attribute;
    }

    public function getAttributeValues(Product $product)
    {
        $attributes = $product->group->attributes ?? [];

        foreach ($attributes as $attribute) {
            $attributeValue = $attribute->values()
                ->where('product_id', $product->id)
                ->where('locale', $this->locale)->first();

            $translation = $attribute->hasTranslation($this->locale) ?
                $attribute->getTranslation($this->locale) :
                $attribute->translations()->first();

            $attribute->value = $attributeValue ? $attributeValue->value : '';
            $attribute->title = $translation->title;
        }

        return $attributes;
    }
}

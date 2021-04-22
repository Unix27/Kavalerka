<?php


namespace Localization\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Localization;

class TranslationTableResource extends JsonResource
{
    public function toArray($request)
    {

        $result = [
            'group' => $this->group,
            'key' => $this->key,
        ];

//        foreach (Localization::getSupportedLocales() as $locale => $locParams) {
//
//            $translation = Localization\Models\Translation::where('group', $result['group'])
//                ->where('key', $result['key'])
//                ->where('locale', $locale)->first();
//
//            if($translation) {
//                $result[$locale] = [
//                    'id' => $translation->id,
//                    'value' => $translation->value,
//                    'status' => $translation->status,
//                ];
//            }
//        }

//        $translation = Localization\Models\Translation::where('group', $result['group'])
//            ->where('key', $result['key'])
//            ->where('locale', 'ru')->first();



        $locales = Localization\Models\Locale::where('active',1)->orderBy('default','desc')->get()->groupBy('code');

        $last_translation = 2;

        foreach ($locales as $locale => $locParams) {

            $translation = Localization\Models\Translation::where('group', $result['group'])
                ->where('key', $result['key'])
                ->where('locale', $locale)->first();




            $last_translation = null;
            if($translation) {
                $last_translation = $translation;

                $result[$locale] = [
                    'id' => $translation->id,
                    'value' => $translation->value,
                    'status' => $translation->status,
                ];
            }else{
                $trans = Localization\Models\Translation::create([
                    'locale' => $locale,
                    'group' =>  $result['group'],
                    'key' => $result['key'],
                    'value' => 'Не задано',
                    'status' => 0,
                ]);

                $result[$locale] = [
                    'id' => $trans->id,
                    'value' => $trans->value,
                    'status' => $trans->status,
                ];
            }
        }

        return $result;
    }
}

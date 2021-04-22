<?php


namespace Localization\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Session;

class ChangeLocale extends Controller
{
    public function change($locale)
    {
        if(\Localization::checkLocaleInSupportedLocales($locale)) {
            Session::put('locale', $locale);
        }
        return back();
    }
}

<?php


namespace Core\Settings\Api\Controllers;


use App\Http\Controllers\Controller;
use Core\Settings\Helpers\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->middleware('admin');
        $this->helper = app(Settings::class);
    }

    public function index()
    {
        $settingsUI = $this->helper->loadConfig(config('settings', []));

        return response()->json([
            'data' => $settingsUI,
            'values' => $this->helper->all(),
            'all_inputs' => $this->helper->getAllSettingFields(),
        ]);

    }

    public function save(Request $request)
    {
        $this->helper->save($request, app()->getLocale());

        return response()->json([
            'values' => $this->helper->all()
        ]);
    }
}

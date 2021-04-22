<?php


namespace Admin\Http\Controllers;


use Admin\Models\Admin;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {

        return view('admin::layouts.master');
    }
}

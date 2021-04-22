<?php


namespace Admin\Http\Controllers;


use App\Http\Controllers\Controller;


class AdminPermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin::permissions.index');
    }
}
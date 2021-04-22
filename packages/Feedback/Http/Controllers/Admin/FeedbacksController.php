<?php


namespace Feedback\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Feedback\DataGrids\FeedbackDataGrid;
use Illuminate\Http\Request;
use Feedback\Models\Feedback as Model;


class FeedbacksController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $datagrid = new FeedbackDataGrid();
        return view('feedback::admin.feedbacks.index', compact('datagrid'));
    }
}

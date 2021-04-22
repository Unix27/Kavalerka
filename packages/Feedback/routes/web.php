<?php
Route::resource('admin/feedback', 'Feedback\Http\Controllers\Admin\FeedbacksController')
    ->names('admin.feedback');



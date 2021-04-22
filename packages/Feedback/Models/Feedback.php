<?php

namespace Feedback\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Feedback extends Model
{
    protected $fillable = ['email', 'message'];
}

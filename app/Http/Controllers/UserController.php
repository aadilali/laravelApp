<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return 'This is user index page';
    }

    public function admin_function()
    {
        return 'This is Admin funtion';
    }

    public function staff_function()
    {
        return 'This is Staff funtion';
    }

    public function customer_function()
    {
        return 'This is Customer function';
    }
}

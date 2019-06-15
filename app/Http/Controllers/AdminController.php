<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
      return "Halaman Admin";
    }

    public function method_lain()
    {
      return "Bisa Delete";
    }
}

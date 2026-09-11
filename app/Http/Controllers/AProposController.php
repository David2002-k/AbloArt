<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\View\View;

class AProposController extends Controller
{
    public function index(): View
    {
        $admin = Admin::with('user')->first();

        return view('a-propos.index', compact('admin'));
    }
}

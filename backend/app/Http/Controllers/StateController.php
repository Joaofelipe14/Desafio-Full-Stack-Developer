<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        return State::all();
    }
}

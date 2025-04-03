<?php

namespace App\Http\Controllers;


use App\Models\States;


class StateController extends Controller
{
    public function index()
    {
        return States::all();
    }
}

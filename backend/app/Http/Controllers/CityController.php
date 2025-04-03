<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return Cities::with('state')->get();
    }
}

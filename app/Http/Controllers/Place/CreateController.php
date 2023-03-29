<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function show(){
        return view('place.create');
    }
}

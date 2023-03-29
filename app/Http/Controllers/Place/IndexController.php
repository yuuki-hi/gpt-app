<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function show(Request $request){
        $places = Place::all();        
        return view('place.index') -> with('places',$places);
    }

    public function showId($id){
        $place = Place::find($id);        
        return view('place.show') -> with('place',$place);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\City;

class ProfileController extends Controller
{
	  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function index(Request $request)
	{
	    $profiles = Profile::get();
	    $cities = City::get();
// dd($cities);
$cities_dict = array();
foreach ($cities as $city) {
	$cities_dict[$city->id] = $city->name;
}
	    return view('profiles.index', [
	        'profiles' => $profiles,
	        'cities' => $cities_dict,
	    ]);
	}
}

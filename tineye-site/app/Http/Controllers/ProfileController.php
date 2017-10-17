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
    public function thumb(Request $request)
	{
	    return view('profiles.thumb', [
	        'id' => $request->id,
	    ]);
	}
    public function detail(Request $request)
	{
		$details = Profile::select('city_id')->where('id', $request->id)->get()->first;
		$cities = City::select('name')->where('id', $details->city_id->city_id)->get()->first;
		// $cities = City::get();
		// dd($cities->name->name);
		$cities_map = array(
			"New Delhi"=>"Delhi",
			"Mumbai"=>"Mumbai",
			);

		$cities_dict = array();
		foreach ($cities as $city) {
			$cities_dict[$city->id] = $city->name;
		}

	    return view('profiles.detail', [
	        'city' => $cities_map[$cities->name->name],
	        'id' => $request->id,
	    ]);
	}
}

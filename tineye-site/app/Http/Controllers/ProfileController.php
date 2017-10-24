<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\City;
use View;

class ProfileController extends Controller
{
	  /**
     * Create a new controller instance.
     *
     * @return void
     */
	  private $cities_map;
    public function __construct()
    {
        // $this->middleware('auth');

		$this->cities_map = array(
			"New Delhi"=>"Delhi",
			"Mumbai"=>"Mumbai",
			"Bengaluru"=>"Bengaluru",
			);
		View::share('cities_map', json_encode($this->cities_map));
		
    }
    public function index(Request $request)
	{
		$name = $request->get("name");
		$sex = $request->get("sex");
		$city = $request->get("city");
		$age_from = $request->get("age_from");
		$age_to = $request->get("age_to");
		
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
		
// dd(json_encode($cities_map));
		$cities_dict = array();
		foreach ($cities as $city) {
			$cities_dict[$city->id] = $city->name;
		}

	    return view('profiles.detail', [
	        'city' => $this->cities_map[$cities->name->name],
	        'id' => $request->id,
	    ]);
	}
}

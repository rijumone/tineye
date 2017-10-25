<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\City;
use View;
use App\Repositories\ProfileRepository;

class ProfileController extends Controller {

    private $cities_map;
    protected $profiles;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProfileRepository $profiles) {
        // $this->middleware('auth');
        $this->profiles = $profiles;

        $this->cities_map = array(
            "New Delhi" => "Delhi",
            "Mumbai" => "Mumbai",
            "Bengaluru" => "Bengaluru",
        );
        View::share('cities_map', json_encode($this->cities_map));
    }

    public function index(Request $request) {
        $filter_params = array();
        if ($request->get("name"))
            $filter_params["name"] = $request->get("name");
        if ($request->get("sex"))
            $filter_params["sex"] = $request->get("sex");
        if ($request->get("city"))
            $filter_params["city"] = $request->get("city");
        if ($request->get("age_from"))
            $filter_params["age_from"] = $request->get("age_from");
        if ($request->get("age_to"))
            $filter_params["age_to"] = $request->get("age_to");
        if ($filter_params)
            $profiles = $this->profiles->filter($filter_params);
        else
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

    public function thumb(Request $request) {
        return view('profiles.thumb', [
            'id' => $request->id,
        ]);
    }

    public function detail(Request $request) {
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

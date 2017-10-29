<?php

namespace App\Repositories;

use App\Profile;
use App\City;

class ProfileRepository {

    /**
     * Get filtered profiles.
     *
     * @param  request
     * @return Collection
     */

    public function filter($filter_params) {

        // get Cities list

        // $profile = Profile::find(1504384625);
        // dd($profile->city);
        $_ = Profile::where('active', 1);
        if (!empty($filter_params['name'])){
            $_->where(function($query) use($filter_params){
                $query->where('first_name','like','%'.$filter_params['name'].'%');
                $query->orWhere('last_name','like','%'.$filter_params['name'].'%');
            });
        }    
        if (!empty($filter_params['sex'])){
            $_->where('sex', $filter_params['sex']);
        }
        if (!empty($filter_params['city'])){
            $city_id = City::where('name', $filter_params['city'])->get()->first();
            if (!empty($city_id)){
                $_->where('city_id', $city_id->id);
            }
        }
        if (!empty($filter_params['age_from']) && !empty($filter_params['age_to'])){
            $_->whereBetween('age', [$filter_params['age_from'],$filter_params['age_to']]);
        }


        $result = $_->orderBy('id', 'desc')
                ->paginate(10);
        // dd($result);
        return $result;
    }

}

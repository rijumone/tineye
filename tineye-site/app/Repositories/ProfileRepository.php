<?php

namespace App\Repositories;

use App\Profile;

class ProfileRepository {

    /**
     * Get filtered profiles.
     *
     * @param  request
     * @return Collection
     */

    public function filter($filter_params) {
        $_ = Profile::where('active', 1);

        if ($filter_params['name']){
            $_->where('first_name','like','%'.$filter_params['name'].'%');
            // $_->orWhere('last_name','like','%'.$filter_params['name'].'%');
        }    
        if ($filter_params['sex']){
            $_->where('sex', $filter_params['sex']);
        }
        if ($filter_params['age_from'] && $filter_params['age_to']){
            $_->whereBetween('age', [$filter_params['age_from'],$filter_params['age_to']]);
        }


        $result = $_->orderBy('created_at', 'asc')
                ->get();
        // dd($result);
        return $result;
    }

}

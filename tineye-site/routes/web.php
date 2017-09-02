<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Profile;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/seed', function (Profile $profile) {
    $f = \Faker\Factory::create();
    foreach(range(0,1000) as $x){
    	$profile->create([
    		'first_name' => $f->firstName(),
    		'last_name' => $f->lastName(),
    		'age' => $f->numberBetween($min = 18, $max = 100),
    		'sex' => $f->randomElement(['man','woman']),
    		'active' => $f->numberBetween($min = 0, $max = 1),
    		'bio' => $f->paragraph($nbSentences = 3, $variableNbSentences = true),
    		'instagram' => $f->url(),
    		'spotify' => $f->url(),
    		'school_id' => $f->numberBetween($min = 1, $max = 10),
    		'work_id' => $f->numberBetween($min = 1, $max = 10),
    		'locality_id' => $f->numberBetween($min = 1, $max = 10),
    		'city_id' => $f->numberBetween($min = 1, $max = 10),
    		'state_id' => $f->numberBetween($min = 1, $max = 7),
    		'country_id' => $f->numberBetween($min = 1, $max = 5),
    	]);
    }
});

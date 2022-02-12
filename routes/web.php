<?php

use App\Models\{
    User,
    Preference
};
use Illuminate\Support\Facades\Route;

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

Route::get('/one-to-one', function () {
    $user = User::first();

    $data = [
        'background_color' => '#000',
    ];

    if ($user->preference) {
        $user->preference->update($data);
    } else {
        //$user->preference()->create($data); OU
        $preference = new Preference($data);
        $user->preference()->save($preference);
    }



    $user->refresh();
});

Route::get('/', function () {
    return view('welcome');
});

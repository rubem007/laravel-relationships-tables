<?php

use App\Models\{
    Course,
    Permission,
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

Route::get('/many-to-many-pivot', function () {
    $user = User::find(1);
    /* $user->permissions()->attach([
        2 => ['active' => false],
    ]); */

    echo "<br> {$user->name} </br>";
    foreach ($user->permissions as $permission) {
        echo "{$permission->name} - {$permission->pivot->active} <br>";
    }
});

Route::get('/many-to-many', function () {
    //dd(Permission::create(['name' => 'menu_03']));

    $user = User::find(1);

    $permission = Permission::find(1);
    $user->permissions()->save($permission); //Save only one permission
    /* $user->permissions()->saveMany([
        Permission::find(4),
        Permission::find(3),
    ]); */
    //$user->permissions()->sync([1, 4]); Elimina as permissões do user e insere as novas permissões
    //$user->permissions()->attach([1, 3]);
    //$user->permissions()->detach([1]); // Elimina as permissões do user

    $user->refresh();

    dd($user->permissions);
});

Route::get('/one-to-many', function () {
    //$course = Course::create(['name' => 'Curso de Laravel']);

    $course = Course::first();

    $data = ['name' => 'Módulo x2'];

    $course->modules()->create($data); //Insere o módulo a partir do relacionamento

    // $course->modules()->get();
    $modules = $course->modules;

    dd($modules);
});

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

    /* 
    Delele preference
    $user->preference->delete();
     */
    dd($user->preference);
});

Route::get('/', function () {
    return view('welcome');
});

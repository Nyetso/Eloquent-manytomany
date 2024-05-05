<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create', function(){
    $user = User::findOrFail(2);
    $role = new Role;
    $role->name = "Manager";
    $user->roles()->save($role);

    // $user = User::findOrFail(1);
    // $role = Role::findOrFail(1);
    // $role->name = "Admnistrator";
    // $user->roles()->save($role);
});

Route::get('/read', function(){
    $user = User::findOrFail(1);
    foreach($user->roles as $role)
    {
        return $role->name;
    }
});

Route::get('/update', function(){
    $user = User::findOrFail(1);
    // foreach($user->roles as $role)
    // {
    //     $role->name = "Administrator";
    //     $role->save();
    // }
    if($user->has('roles'))
    {
        foreach($user->roles as $role)
        {
            if($role->name == 'Administrator')
            {
                $role->name = strtolower($role->name);
                $role->save();
            }
        }
    }
});

Route::get('/delete', function(){
    $user = User::findOrFail(1);
    //only delete roles table
    if($user->has('roles'))
    {
        foreach($user->roles as $role)
        {
            $role->delete();
        }
    }

    //delete including relations
    // $user->roles()->delete();
});

Route::get('/attach', function(){
    $user = User::findOrFail(3);
    $user->roles()->attach(1);
});

Route::get('/detach', function(){
    $user = User::findOrFail(3);
    $user->roles()->detach(1);
});

Route::get('/sync', function(){
    $user::findOrFail(3);
    $user->roles()->sync([2]);
});
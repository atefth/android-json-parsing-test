<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->welcome();
});

// Login a user
$app->post('login', 'AuthController@login');
// Find all or one band
$app->get('bands/{id}', 'BandController@find');
// Find all or one user
$app->get('users/{id}', 'UserController@find');
// Add a new user
$app->post('users', 'UserController@store');
// Add a user as a band member
$app->get('join/{user_id}/{band_id}', 'UserController@joinBand');
// Remove a user as a band member
$app->get('leave/{user_id}/{band_id}', 'UserController@leaveBand');

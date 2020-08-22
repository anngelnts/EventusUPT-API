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

$router->group(['prefix' => 'api'], function () use ($router) {
    // $router->get('/events', ['middleware' => 'auth', 'EventController@List']);

    //user ok
    $router->post('users/register', 'AuthController@Register');
    $router->post('users/login', 'AuthController@Login');
    $router->get('users/profile', 'UserController@Profile');
    $router->post('users/profile', 'UserController@UpdateProfile');
    $router->post('users/change-password', 'UserController@ChangePassword');
    $router->get('users/my-events', 'UserController@MyEvents');
    $router->get('users/my-event/{id}', 'UserController@MyEvent');
    $router->get('users/my-events-qr', 'UserController@MyEventsQR');
    $router->post('users/qr-authentication', 'AuthController@QrAuthentication');

    //organizer ok
    $router->post('organizers/register', 'AuthOrganizerController@Register');
    $router->post('organizers/login', 'AuthOrganizerController@Login');
    $router->get('organizers/profile', 'OrganizerController@Profile');
    $router->post('organizers/profile', 'OrganizerController@UpdateProfile');
    $router->post('organizers/change-password', 'OrganizerController@ChangePassword');
    $router->get('organizers/my-events', 'OrganizerController@MyEvents');
    $router->get('organizers/my-event/{id}/participants', 'OrganizerController@MyEventParticipants');

    //lists ok
    $router->get('audiences', 'AudienceController@List');
    $router->get('event-types', 'EventTypeController@List');
    $router->get('universities', 'UniversityController@List');
    $router->get('faculties', 'FacultyController@List');
    $router->get('schools', 'SchoolController@List');

    //event ok
    $router->get('events', 'EventController@List');
    $router->get('events/{id}', 'EventController@View');
    $router->post('events', 'EventController@Store');
    $router->post('events/{id}', 'EventController@Update');
    $router->post('events/register/participant', 'EventController@StoreParticipant');
    $router->post('events/update/participant', 'EventController@UpdateParticipant');
    
    
});
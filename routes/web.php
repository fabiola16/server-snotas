<?php
$router->post('/',function(){
    return str_random(60);
})
/* Rutas publicas*/
/* Rutas para login y logout*/
$router->post('/login', ['uses' => 'UserController@login']);
$router->post('/logout', ['uses' => 'UserController@logout']);
/* Rutas para registar usuarios*/
$router->post('/users', ['uses' => 'UserController@createUser']);
/**********************************************************************************************************************/

/* Rutas con autenticacion*/
$router->group(['middleware' => []], function () use ($router) {
    /* Rutas para los usuarios*/
    $router->get('/users', ['uses' => 'UserController@getAllUsers']);
    $router->get('/users/{id}', ['uses' => 'UserController@showUser']);
    $router->put('/users', ['uses' => 'UserController@updateUser']);
    $router->delete('/users', ['uses' => 'UserController@deleteUser']);
    /**********************************************************************************************************************/

    /* Rutas para los profesionales*/
    $router->get('/professionals/languages', ['uses' => 'ProfessionalController@getLanguages']);
    $router->get('/professionals/{id}', ['uses' => 'ProfessionalController@showProfessional']);
    $router->post('/professionals', ['uses' => 'ProfessionalController@createProfessional']);
    $router->put('/professionals', ['uses' => 'ProfessionalController@updateProfessional']);
    $router->delete('/professionals', ['uses' => 'ProfessionalController@deleteProfessional']);
    /**********************************************************************************************************************/

    /* Rutas para los idiomas*/
    $router->get('/languages/{id}', ['uses' => 'LanguageController@showLanguage']);
    $router->post('/languages', ['uses' => 'LanguageController@createLanguage']);
    $router->put('/languages', ['uses' => 'LanguageController@updateLanguage']);
    $router->delete('/languages', ['uses' => 'LanguageController@deleteLanguage']);
    /**********************************************************************************************************************/

    /* Rutas para los roles*/
    $router->get('/roles', ['uses' => 'RoleController@getAllRoles']);
    $router->get('/roles/{id}', ['uses' => 'RoleController@showRole']);
    $router->post('/roles', ['uses' => 'RoleController@createRole']);
    $router->put('/roles', ['uses' => 'RoleController@updateRole']);
    $router->delete('/roles', ['uses' => 'RoleController@deleteRole']);
    /**********************************************************************************************************************/
});


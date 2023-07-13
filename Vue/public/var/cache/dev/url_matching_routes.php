<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/index' => [[['_route' => 'api_index', '_controller' => 'App\\Controller\\ApiController::index'], null, ['GET' => 0], null, false, false, null]],
        '/api/create' => [[['_route' => 'api_create', '_controller' => 'App\\Controller\\ApiController::create'], null, ['POST' => 0], null, false, false, null]],
        '/api/reminder' => [[['_route' => 'api_reminder', '_controller' => 'App\\Controller\\ApiController::reminder'], null, ['PUT' => 0], null, false, false, null]],
        '/api/deleteTask' => [[['_route' => 'api_delete', '_controller' => 'App\\Controller\\ApiController::deleteTask'], null, ['DELETE' => 0], null, false, false, null]],
        '/auth/register' => [[['_route' => 'auth_register', '_controller' => 'App\\Controller\\AuthController::register'], null, null, null, false, false, null]],
        '/auth/login' => [[['_route' => 'auth_login', '_controller' => 'App\\Controller\\AuthController::login'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

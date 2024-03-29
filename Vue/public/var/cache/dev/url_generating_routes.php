<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], [], []],
    'api_index' => [[], ['_controller' => 'App\\Controller\\ApiController::index'], [], [['text', '/api/index']], [], [], []],
    'api_create' => [[], ['_controller' => 'App\\Controller\\ApiController::create'], [], [['text', '/api/create']], [], [], []],
    'api_reminder' => [[], ['_controller' => 'App\\Controller\\ApiController::reminder'], [], [['text', '/api/reminder']], [], [], []],
    'api_delete' => [[], ['_controller' => 'App\\Controller\\ApiController::deleteTask'], [], [['text', '/api/deleteTask']], [], [], []],
    'auth_register' => [[], ['_controller' => 'App\\Controller\\AuthController::register'], [], [['text', '/auth/register']], [], [], []],
    'auth_login' => [[], ['_controller' => 'App\\Controller\\AuthController::login'], [], [['text', '/auth/login']], [], [], []],
];

<?php
/**
 * Define your routes here.
 */
return [
    // Note: Controller & Action suffixes are not needed.
    // So "Index.favicon" => "system/Index/IndexController::faviconAction()".

    // Index route.
    '/' => 'App.index',

    // API routes.
    '/api/auth'         => ['POST' => 'Api.auth'],
    '/api/purchase'     => ['POST' => 'Api.purchase'],
    '/api/subscription' => ['POST' => 'Api.subscription'],
    '/api/chat'         => ['POST' => 'Api.chat'],

    // More..
    // '/user/:id' => ['GET' => 'User.show'],
    // '/user/:id' => ['GET' => function ($id) { ... }],
];

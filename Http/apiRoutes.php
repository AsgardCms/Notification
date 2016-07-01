<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->post('notification/mark-read', ['as' => 'api.notification.read', 'uses' => 'NotificationsController@markAsRead']);

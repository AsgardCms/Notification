<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/notification'], function (Router $router) {
    $router->get('notifications', [
        'as' => 'admin.notification.notification.index',
        'uses' => 'NotificationsController@index',
        'middleware' => 'can:notification.notifications.index',
    ]);
    $router->get('notifications/markAllAsRead', [
        'as' => 'admin.notification.notification.markAllAsRead',
        'uses' => 'NotificationsController@markAllAsRead',
        'middleware' => 'can:notification.notifications.markAllAsRead',
    ]);
    $router->delete('notifications/destroyAll', [
        'as' => 'admin.notification.notification.destroyAll',
        'uses' => 'NotificationsController@destroyAll',
        'middleware' => 'can:notification.notifications.destroyAll',
    ]);
    $router->delete('notifications/{notification}', [
        'as' => 'admin.notification.notification.destroy',
        'uses' => 'NotificationsController@destroy',
        'middleware' => 'can:notification.notifications.destroy',
    ]);
});

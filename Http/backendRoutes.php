<?php

$router->group(['prefix' => '/notification'], function () {
    get('notifications', ['as' => 'admin.notification.notification.index', 'uses' => 'NotificationsController@index']);
    get('notifications/markAllAsRead', ['as' => 'admin.notification.notification.markAllAsRead', 'uses' => 'NotificationsController@markAllAsRead']);
    delete('notifications/destroyAll', ['as' => 'admin.notification.notification.destroyAll', 'uses' => 'NotificationsController@destroyAll']);
    delete('notifications/{notification}', ['as' => 'admin.notification.notification.destroy', 'uses' => 'NotificationsController@destroy']);
});

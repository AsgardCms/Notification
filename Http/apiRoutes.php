<?php

post('notification/mark-read', ['as' => 'api.notification.read', 'uses' => 'NotificationsController@markAsRead']);

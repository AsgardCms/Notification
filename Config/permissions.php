<?php

return [
    'notification.notifications' => [
        'index' => 'notification::messages.list resource',
        'destroy' => 'notification::messages.destroy resource',
        'destroyAll' => 'notification::messages.destroy all resource',
        'markAllAsRead' => 'notification::messages.markAllAsRead resource',
    ],
];

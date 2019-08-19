<?php

namespace Modules\Notification\Composers;

use Cartalyst\Sentinel\Sentinel;
use Illuminate\Contracts\View\View;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Contracts\Authentication;

class NotificationViewComposer
{
    /**
     * @var NotificationRepository
     */
    private $notification;
    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(NotificationRepository $notification, Authentication $auth)
    {
        $this->notification = $notification;
        $this->auth = $auth;
    }

    public function compose(View $view)
    {
        $user = \Sentinel::getUser();

        if($user->inRole('employee')) {
            $notifications = $this->notification->latestForUser($user->id);
        } else{
            $notifications = $this->notification->latestForAdmin();
        }    
                
        $view->with('notifications', $notifications);
    }
}

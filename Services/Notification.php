<?php namespace Modules\Notification\Services;

use Modules\Core\Contracts\Authentication;
use Modules\Notification\Events\BroadcastNotification;
use Modules\Notification\Repositories\NotificationRepository;

class Notification
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

    public function push($title, $message, $icon, $link = null)
    {
        $notification = $this->notification->create([
            'user_id' => $this->auth->check()->id,
            'icon_class' => $icon,
            'link' => $link,
            'title' => $title,
            'message' => $message,
        ]);

        event(new BroadcastNotification($notification));
    }
}

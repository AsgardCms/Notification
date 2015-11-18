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

    /**
     * Push a notification on the dashboard
     * @param string $title
     * @param string $message
     * @param string $icon
     * @param string|null $link
     */
    public function push($title, $message, $icon, $link = null)
    {
        $notification = $this->notification->create([
            'user_id' => $this->auth->check()->id,
            'icon_class' => $icon,
            'link' => $link,
            'title' => $title,
            'message' => $message,
        ]);

        $this->triggerEventFor($notification);
    }

    /**
     * Trigger the broadcast event for the given notification
     * @param \Modules\Notification\Entities\Notification $notification
     */
    private function triggerEventFor(\Modules\Notification\Entities\Notification $notification)
    {
        event(new BroadcastNotification($notification));
    }
}

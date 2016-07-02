<?php

namespace Modules\Notification\Services;

use Modules\Notification\Events\BroadcastNotification;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Contracts\Authentication;

final class AsgardNotification implements Notification
{
    /**
     * @var NotificationRepository
     */
    private $notification;
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var int
     */
    private $userId;

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
            'user_id' => $this->userId ?: $this->auth->id(),
            'icon_class' => $icon,
            'link' => $link,
            'title' => $title,
            'message' => $message,
        ]);

        if (true === config('asgard.notification.config.real-time', false)) {
            $this->triggerEventFor($notification);
        }
    }

    /**
     * Trigger the broadcast event for the given notification
     * @param \Modules\Notification\Entities\Notification $notification
     */
    private function triggerEventFor(\Modules\Notification\Entities\Notification $notification)
    {
        event(new BroadcastNotification($notification));
    }

    /**
     * Set a user id to set the notification to
     * @param int $userId
     * @return $this
     */
    public function to($userId)
    {
        $this->userId = $userId;

        return $this;
    }
}

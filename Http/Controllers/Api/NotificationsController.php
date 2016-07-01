<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notification\Repositories\NotificationRepository;

class NotificationsController extends Controller
{
    /**
     * @var NotificationRepository
     */
    private $notification;

    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

    public function markAsRead(Request $request)
    {
        $updated = $this->notification->markNotificationAsRead($request->get('id'));

        return response()->json(compact('updated'));
    }
}

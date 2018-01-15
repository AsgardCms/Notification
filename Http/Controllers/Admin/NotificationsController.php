<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Contracts\Authentication;

class NotificationsController extends AdminBaseController
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
        parent::__construct();

        $this->notification = $notification;
        $this->auth = $auth;
    }

    public function index()
    {
        $notifications = $this->notification->allForUser($this->auth->id());

        return view('notification::admin.notifications.index', compact('notifications'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Notification $notification
     * @return Response
     */
    public function destroy(Notification $notification)
    {
        $this->notification->destroy($notification);

        return redirect()->route('admin.notification.notification.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => 'Notification']));
    }

    public function destroyAll()
    {
        $this->notification->deleteAllForUser($this->auth->id());

        return redirect()->route('admin.notification.notification.index')
            ->withSuccess(trans('notification::messages.all notifications deleted'));
    }

    public function markAllAsRead()
    {
        $this->notification->markAllAsReadForUser($this->auth->id());

        return redirect()->route('admin.notification.notification.index')
            ->withSuccess(trans('notification::messages.all notifications marked as read'));
    }
}

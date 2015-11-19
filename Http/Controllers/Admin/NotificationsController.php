<?php namespace Modules\Notification\Http\Controllers\Admin;

use Modules\Core\Contracts\Authentication;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationRepository;

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
        $notifications = $this->notification->allForUser($this->auth->check()->id);

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

        flash(trans('core::core.messages.resource deleted', ['name' => 'Notification']));

        return redirect()->route('admin.notification.notification.index');
    }

    public function destroyAll()
    {
        $this->notification->deleteAllForUser($this->auth->check()->id);

        flash(trans('notification::messages.all notifications deleted'));

        return redirect()->route('admin.notification.notification.index');
    }

    public function markAllAsRead()
    {
        $this->notification->markAllAsReadForUser($this->auth->check()->id);

        flash(trans('notification::messages.all notifications marked as read'));

        return redirect()->route('admin.notification.notification.index');
    }
}

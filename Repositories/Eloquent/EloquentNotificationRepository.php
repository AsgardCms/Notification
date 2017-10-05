<?php

namespace Modules\Notification\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Notification\Repositories\NotificationRepository;

final class EloquentNotificationRepository extends EloquentBaseRepository implements NotificationRepository
{
    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latestForUser($userId)
    {
        return $this->model->whereUserId($userId)->whereIsRead(false)->orderBy('created_at', 'desc')->take(10)->get();
    }

    /**
     * Mark the given notification id as "read"
     * @param int $notificationId
     * @return bool
     */
    public function markNotificationAsRead($notificationId)
    {
        $notification = $this->find($notificationId);
        $notification->is_read = true;

        return $notification->save();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get all the notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForUser($userId)
    {
        return $this->model->whereUserId($userId)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get all the read notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allReadForUser($userId)
    {
        return $this->model->whereUserId($userId)->whereIsRead(true)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get all the unread notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allUnreadForUser($userId)
    {
        return $this->model->whereUserId($userId)->whereIsRead(false)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Delete all the notifications for the given user
     * @param int $userId
     * @return bool
     */
    public function deleteAllForUser($userId)
    {
        return $this->model->whereUserId($userId)->delete();
    }

    /**
     * Mark all the notifications for the given user as read
     * @param int $userId
     * @return bool
     */
    public function markAllAsReadForUser($userId)
    {
        return $this->model->whereUserId($userId)->update(['is_read' => true]);
    }
}

<?php namespace Modules\Notification\Repositories\Eloquent;

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
}

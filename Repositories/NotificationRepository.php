<?php namespace Modules\Notification\Repositories;

use Modules\Core\Repositories\BaseRepository;

/**
 * Interface NotificationRepository
 * @package Modules\Notification\Repositories
 */
interface NotificationRepository extends BaseRepository
{
    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latestForUser($userId);

    /**
     * Mark the given notification id as "read"
     * @param int $notificationId
     * @return bool
     */
    public function markNotificationAsRead($notificationId);
}

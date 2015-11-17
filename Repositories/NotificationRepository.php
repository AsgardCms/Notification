<?php namespace Modules\Notification\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface NotificationRepository extends BaseRepository
{
    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latestForUser($userId);
}

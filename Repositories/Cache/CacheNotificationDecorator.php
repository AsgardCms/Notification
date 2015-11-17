<?php namespace Modules\Notification\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Notification\Repositories\NotificationRepository;

class CacheNotificationDecorator extends BaseCacheDecorator implements NotificationRepository
{
    public function __construct(NotificationRepository $notification)
    {
        parent::__construct();
        $this->entityName = 'notification.notifications';
        $this->repository = $notification;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latestForUser($userId)
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.latestForUser.{$userId}", $this->cacheTime,
                function () use ($userId) {
                    return $this->repository->latestForUser($userId);
                }
            );
    }
}

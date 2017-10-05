<?php

namespace Modules\Notification\Tests;

use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationRepository;

class EloquentNotificationRepositoryTest extends BaseTestCase
{
    /**
     * @var NotificationRepository
     */
    private $notification;

    public function setUp()
    {
        parent::setUp();
        $this->notification = app(NotificationRepository::class);
    }

    /** @test */
    public function it_can_create_a_notification()
    {
        $notification = $this->notification->create([
            'user_id' => 1,
            'icon_class' => 'fa fa-link',
            'link' => 'http://localhost/users',
            'title' => 'My notification',
            'message' => 'Is awesome!',
        ]);

        $this->assertCount(1, $this->notification->all());
        $this->assertEquals('1' , $notification->user_id);
        $this->assertEquals('fa fa-link' , $notification->icon_class);
        $this->assertEquals('http://localhost/users' , $notification->link);
        $this->assertEquals('My notification' , $notification->title);
        $this->assertEquals('Is awesome!' , $notification->message);
    }

    /** @test */
    public function it_can_fetch_latest_notification_for_user()
    {
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification(['user_id' => 2]);
        $this->createNotification(['user_id' => 2]);

        $this->assertCount(10, $this->notification->latestForUser(1));
        $this->assertCount(2, $this->notification->latestForUser(2));
    }

    /** @test */
    public function it_can_get_all_notifications_for_user()
    {
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification(['user_id' => 2]);
        $this->createNotification(['user_id' => 2]);

        $this->assertCount(11, $this->notification->allForUser(1));
        $this->assertCount(2, $this->notification->allForUser(2));
    }

    /** @test */
    public function it_can_mark_a_notification_as_read()
    {
        $notification = $this->createNotification();

        $this->assertFalse($notification->isRead());
        $this->notification->markNotificationAsRead($notification->id);

        $notification->refresh();
        $this->assertTrue($notification->isRead());
    }

    /** @test */
    public function it_can_get_all_unread_notifications_for_user()
    {
        $this->createNotification();
        $this->createNotification(['is_read' => true]);
        $this->createNotification(['is_read' => true]);
        $this->createNotification();

        $this->assertCount(2, $this->notification->allUnreadForUser(1));
    }

    /** @test */
    public function it_can_get_all_read_notifications_for_user()
    {
        $this->createNotification();
        $this->createNotification(['is_read' => true]);
        $this->createNotification(['is_read' => true]);
        $this->createNotification();
        $this->createNotification();

        $this->assertCount(2, $this->notification->allReadForUser(1));
    }

    /** @test */
    public function it_can_delete_all_notifications_for_user()
    {
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification(['user_id' => 2]);
        $this->createNotification(['user_id' => 2]);

        $this->assertCount(3, $this->notification->allForUser(1));
        $this->assertCount(2, $this->notification->allForUser(2));

        $this->notification->deleteAllForUser(1);

        $this->assertCount(0, $this->notification->allForUser(1));
        $this->assertCount(2, $this->notification->allForUser(2));
    }

    /** @test */
    public function it_can_mark_all_notifications_read_for_user()
    {
        $this->createNotification();
        $this->createNotification();
        $this->createNotification();
        $this->createNotification(['user_id' => 2]);
        $this->createNotification(['user_id' => 2]);

        $this->assertCount(0, $this->notification->allReadForUser(1));

        $this->notification->markAllAsReadForUser(1);
        $this->assertCount(3, $this->notification->allReadForUser(1));
    }

    private function createNotification(array $properties = []) : Notification
    {
        $data = [
            'user_id' => 1,
            'icon_class' => 'fa fa-link',
            'link' => 'http://localhost/users',
            'title' => 'My notification',
            'message' => 'Is awesome!',
        ];

        return $this->notification->create(array_merge($data, $properties));
    }
}

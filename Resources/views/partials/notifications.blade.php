<style>
    .notificationsCounter {
        animation-duration: .5s;
    }
    .notificationIcon {
        font-size: 30px;
    }
</style>
<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-bell-o"></i>
        <span class="label label-success notificationsCounter animated">{{ $notifications->count() }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <div class="slimScrollDiv">
                <ul class="menu notifications-list">
                    <?php if ($notifications->count() === 0): ?>
                    <li class="noNotifications">
                        <a href="">
                            No notifications
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php foreach ($notifications as $notification): ?>
                    <li>
                        <a href="{{ $notification->link }}">
                            <div class="pull-left notificationIcon">
                                <i class="{{ $notification->icon_class }}"></i>
                            </div>
                            <h4>
                                {{ $notification->title }}
                                <small><i class="fa fa-clock-o"></i> {{ $notification->time_ago }}</small>
                            </h4>
                            <p>{{ $notification->message }}</p>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>
    </ul>
</li>

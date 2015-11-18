# Notification module

Quickly send (real-time) notifications to your AsgardCms application. 

 
  ``` php
  $this->notification->push('New subscription', 'Someone has subscribed!', 'fa fa-hand-peace-o text-green', route('admin.user.user.index'));
  ```
  
  ``` php
 /**
  * Push a notification on the dashboard
  * @param string $title
  * @param string $message
  * @param string $icon
  * @param string|null $link
 */
public function push($title, $message, $icon, $link = null);
 ```

![Notifications demo screenshot](https://cldup.com/Dvb8rrcJLv.thumb.png)
***

## Installation

#### Require the module in your project
```
composer require asgardcms/notification-module
```

#### Publish the configuration

```
php artisan module:publish notification
```

#### Real time ?

If you want real time notifications over websockets, you need to configure the `broadcast.php` config file.

Currently, [Laravel broadcasting](http://laravel.com/docs/5.1/events#broadcasting-events) supports Pusher and Redis, but AsgardCms only has the front-end integration for Pusher. More integrations are welcome via pull-request. Look at the [Pusher integration](https://github.com/AsgardCms/Notification/blob/master/Assets/js/pusherNotifications.js) for inspiration.


## Usage

Usage is simple and straightforward:

### Send notification to logged in user

``` php
$this->notification->push('New subscription', 'Someone has subscribed!', 'fa fa-hand-peace-o text-green', route('admin.user.user.index'));
```

### Send notification to a specific user

``` php
$this->notification->to($userId)->push('New subscription', 'Someone has subscribed!', 'fa fa-hand-peace-o text-green', route('admin.user.user.index'));
```

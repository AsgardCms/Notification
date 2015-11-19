# Notification module

[![Latest Version](https://img.shields.io/packagist/v/asgardcms/notification-module.svg?style=flat-square)](https://github.com/asgardcms/notification/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/asgardcms/notification.svg?style=flat-square)](https://scrutinizer-ci.com/g/asgardcms/notification)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/0d8f61c7-0e2f-46b2-9f63-91f4d5abeca5.svg)](https://insight.sensiolabs.com/projects/0d8f61c7-0e2f-46b2-9f63-91f4d5abeca5)

[![Total Downloads](https://img.shields.io/packagist/dd/asgardcms/notification-module.svg?style=flat-square)](https://packagist.org/packages/asgardcms/notification-module)
[![Total Downloads](https://img.shields.io/packagist/dm/asgardcms/notification-module.svg?style=flat-square)](https://packagist.org/packages/asgardcms/notification-module)
[![Total Downloads](https://img.shields.io/packagist/dt/asgardcms/notification-module.svg?style=flat-square)](https://packagist.org/packages/asgardcms/notification-module)
[![Slack](http://slack.asgardcms.com/badge.svg)](http://slack.asgardcms.com/)


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
[Quick demo](http://quick.as/7rasgvgv)
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

If you want real time notifications over websockets, you need to configure the `broadcasting.php` config file. After that is done, set the `asgard.notification.config.real-time` option to `true`.

Currently, [Laravel broadcasting](http://laravel.com/docs/5.1/events#broadcasting-events) supports Pusher and Redis, but AsgardCms only has the front-end integration for Pusher. More integrations are welcome via pull-request. Look at the [Pusher integration](https://github.com/AsgardCms/Notification/blob/master/Assets/js/pusherNotifications.js) for inspiration.


## Usage

Usage is simple and straightforward:

Inject the `Modules\Notification\Services\Notification` interface where you need it and assign it to a class variable.

### Send notification to logged in user

``` php
$this->notification->push('New subscription', 'Someone has subscribed!', 'fa fa-hand-peace-o text-green', route('admin.user.user.index'));
```

### Send notification to a specific user

``` php
$this->notification->to($userId)->push('New subscription', 'Someone has subscribed!', 'fa fa-hand-peace-o text-green', route('admin.user.user.index'));
```

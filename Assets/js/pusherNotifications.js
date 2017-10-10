;(function ($, window, document, undefined) {
    "use strict";
    var pluginName = "pusherNotifications",
        defaults = {
            notificationsCounter: ".notificationsCounter",
            noNotifications: ".noNotifications"
        };

    function pusherNotifications(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    $.extend(pusherNotifications.prototype, {
        getTemplate: function () {
            return '<li>' +
                '<a href="#">' +
                '<div class="pull-left notificationIcon"><i class="iconClass"></i></div>' +
                '<h4>' +
                'notificationTitle' +
                '<small><i class="fa fa-clock-o"></i> timeAgo</small>' +
                '</h4>' +
                '<p>notificationMessage</p>' +
                '</a>' +
                '</li>';
        },
        prepareTemplate: function (message) {
            var template = this.getTemplate();
            template = template.replace('iconClass', message.notification.icon_class);
            template = template.replace('#', message.notification.link);
            template = template.replace('notificationTitle', message.notification.title);
            template = template.replace('notificationMessage', message.notification.message);
            template = template.replace('timeAgo', message.notification.time_ago);

            return template;
        },
        incrementCounter: function () {
            var self = this;
            var count = parseInt($(self.settings.notificationsCounter).text());
            $(self.settings.notificationsCounter).text(count + 1);
            $(self.settings.notificationsCounter).addClass('bounce');
            setTimeout(function () {
                $(self.settings.notificationsCounter).removeClass('bounce');
            }, 1000);
        },
        init: function () {
            var self = this;
            this.pusher = new Pusher(this.settings.pusherKey, {
                cluster: this.settings.pusherCluster,
                encrypted: this.settings.pusherEncrypted,
            });
            this.pusherChannel = this.pusher.subscribe('asgardcms.notifications.' + this.settings.loggedInUserId);
            this.pusherChannel.bind('Modules\\Notification\\Events\\BroadcastNotification', function (message) {
                if ($(self.settings.noNotifications).length) {
                    $(self.settings.noNotifications).remove();
                }
                $(self.element).prepend(self.prepareTemplate(message));
                $(self.element).find('li').first().addClass('animated pulse');
                self.incrementCounter();
            });
        }
    });

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new pusherNotifications(this, options));
            }
        });
    };

})(jQuery, window, document);

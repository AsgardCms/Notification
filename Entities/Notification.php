<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string type
 * @property string message
 * @property string icon_class
 * @property string title
 * @property string link
 * @property bool is_read
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property int user_id
 */
class Notification extends Model
{
    protected $table = 'notification__notifications';
    protected $fillable = ['user_id', 'type', 'message', 'icon_class', 'link', 'is_read', 'title'];
    protected $appends = ['time_ago'];
    protected $casts = ['is_read' => 'bool'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    /**
     * Return the created time in difference for humans (2 min ago)
     * @return string
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function isRead() : bool
    {
        return $this->is_read === true;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Chat
 * @property int id
 * @property int client_id
 * @property int support_id
 * @property string slug
 * @package App
 */
class Chat extends AbstractModel
{
    use SoftDeletes;

    /**
     * Property
     */
    public const ID = 'id';
    public const CLIENT_ID = 'client_id';
    public const SUPPORT_ID = 'support_id';
    public const SLUG = 'slug';

    /**
     * @var array
     */
    protected $fillable = [
        self::CLIENT_ID,
        self::SUPPORT_ID,
        self::SLUG,
    ];

    /**
     * Relation
     */
    public const MESSAGES = 'messages';

    /**
     * @return HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return self::SLUG;
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->{self::SLUG} = $model->{self::SLUG} ?? sha1(microtime());
        });
    }
}

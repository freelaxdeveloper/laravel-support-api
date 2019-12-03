<?php

namespace App;

use App\Events\MessageUpdateEvent;
use App\Services\ChatService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Message
 * @property array file
 * @property int id
 * @property string message
 * @property BelongsTo chat
 * @package App
 */
class Message extends AbstractModel
{
    use SoftDeletes;

    /**
     * Property
     */
    public const ID = 'id';
    public const MESSAGE = 'message';
    public const CHAT_ID = 'chat_id';
    public const GUEST_ID = 'guest_id';
    public const META = 'meta';
    public const FILE = 'file';
    public const TYPE = 'type';
    public const IS_READ = 'is_read';
    public const IS_LIKE = 'is_like';
    public const IS_EDITED = 'is_edited';

    public const GUEST = 'guest';

    /**
     * Accessor
     */
    public const AUTHOR = 'author';

    /**
     * @var array
     */
    protected $fillable = [
      self::TYPE,
      self::MESSAGE,
      self::CHAT_ID,
      self::GUEST_ID,
      self::META,
      self::FILE,
//      self::IP_ADDRESS,
    ];

    /**
     * @var array
     */
    protected $appends = [
        self::AUTHOR,
    ];

    /**
     * @var array
     */
    protected $casts = [
        self::IS_READ => 'bool',
        self::IS_LIKE => 'bool',
        self::IS_EDITED => 'bool',
        self::FILE => 'array',
    ];

    /**
     * @return string
     */
    public function getAuthorAttribute()
    {
        $id = customer()->guest->id ?? null;
        $isMe = $this->attributes[self::GUEST_ID] === $id;

        return $isMe ? 'me' : 'support';
    }

    /**
     * @return BelongsTo
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * @return BelongsTo
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * @return BelongsTo
     */
    public function suggestions()
    {
        return $this->belongsTo(Suggestion::class);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function($model)
        {
            if($model->isDirty(self::MESSAGE)) {
                $model->{self::IS_EDITED} = true;
                MessageUpdateEvent::dispatch($model);
            }
        });

        static::creating(function($model)
        {
            $model->{self::CHAT_ID} = $model->{self::CHAT_ID} ?? ChatService::startChat()->id;
        });
    }
}

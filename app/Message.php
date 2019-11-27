<?php

namespace App;

use App\Services\ChatService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Message
 * @property array file
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
    public const USER_ID = 'user_id';
    public const META = 'meta';
    public const FILE = 'file';
    public const TYPE = 'type';
    public const IP_ADDRESS = 'ip_address';
    public const IS_READ = 'is_read';
    public const IS_LIKE = 'is_like';
    public const IS_EDITED = 'is_edited';

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
      self::USER_ID,
      self::META,
      self::FILE,
      self::IP_ADDRESS,
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
        $isUserId = $this->attributes[self::USER_ID] ?? false;

        return !(bool) $isUserId ? 'me' : 'support';
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
            }
        });

        static::creating(function($model)
        {
            $model->{self::CHAT_ID} = ChatService::startChat()->id;
        });
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Chat
 * @property int id
 * @property int client_id
 * @property int support_id
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

    /**
     * @var array
     */
    protected $fillable = [
        self::CLIENT_ID,
        self::SUPPORT_ID,
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
}

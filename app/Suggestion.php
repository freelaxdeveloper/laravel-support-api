<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Suggestion
 * @package App
 */
class Suggestion extends AbstractModel
{
    use SoftDeletes;

    /**
     * Property
     */
    public const ID = 'id';
    public const TEXT = 'text';
    public const MESSAGE_ID = 'message_id';
    public const DELETED_AT = 'deleted_at';

    /**
     * @return BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}

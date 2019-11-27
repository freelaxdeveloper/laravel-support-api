<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractModel
 * @package App
 */
class AbstractModel extends Model
{
    public const CREATED_AT =  'created_at';
    public const UPDATED_AT =  'updated_at';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}

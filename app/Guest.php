<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array, array $array1)
 */
class Guest extends Model
{
    public const ID = 'id';
    public const NAME = 'name';
    public const IP_LONG = 'ip_long';
    public const IP_ADDRESS = 'ip_address';
    public const TOKEN = 'token';
    public const AGENT = 'agent';

    /**
     * @var array
     */
    protected $fillable = [
        self::IP_LONG,
        self::IP_ADDRESS,
        self::TOKEN,
        self::AGENT,
        self::NAME,
    ];

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->attributes[self::NAME] ?? "ID: {$this->attributes[self::ID]}";
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope(self::IP_LONG, function (Builder $builder) {
//            $builder->when(customer()->id, function (Builder $builder) {
//                $builder->where(self::IP_LONG, customer()->id);
//            });
//        });
    }
}

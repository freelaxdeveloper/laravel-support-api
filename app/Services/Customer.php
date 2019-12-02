<?php

namespace App\Services;

use App\Guest;

/**
 * Class Customer
 * @package App\Services
 */
class Customer
{
    public $id;
    public $ip;
    public $token;
    public $agent;
    public $guest;

    private $salt;

    private static $_instanse = null;

    public function __construct()
    {
        $this->salt = env('APP_KEY');
        $this->agent = $this->getAgent();
        $this->ip = $this->getIp();
        $this->id = $this->getId();

        $this->token = $this->getToken();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
          'id' => $this->id,
          'ip' => $this->ip,
          'token' => $this->token,
        ];
    }

    /**
     * @return string|null
     */
    protected function getIp(): ?string
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    /**
     * @return string|null
     */
    protected function getAgent(): ?string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }

    /**
     * @return int
     */
    protected function getId(): int
    {
        return ip2long($this->getIp());
    }

    /**
     * @return $this
     */
    public function firstOrCreate()
    {
        if (!$this->ip) {
            return $this;
        }
        $this->guest = Guest::firstOrCreate([
            Guest::TOKEN => $this->token,
        ], [
            Guest::IP_ADDRESS => $this->ip,
            Guest::IP_LONG => $this->id,
            Guest::AGENT => $this->agent,
        ]);

        return $this;
    }

    /**
     * @return string
     */
    protected function getToken(): string
    {
        $token = base64_encode($this->ip . $this->agent)
            . md5($this->id . $this->agent)
            . sha1($this->salt);

        $token = sha1($token) . md5($token);
        return $token;
    }

    /**
     * @return Customer
     */
    public static function getInstanse()
    {
        if (!self::$_instanse) {
            self::$_instanse = new Customer;
            self::$_instanse->firstOrCreate();
        }

        return self::$_instanse;
    }
}

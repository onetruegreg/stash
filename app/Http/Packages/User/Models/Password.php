<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 8:49 PM
 */

namespace App\Http\Packages\User\Models;

/**
 * Class Password
 * @package app\Http\Packages\User\Models
 */
class Password
{
    /**
     * @var string
     */
    private $salt;

    /**
     * @var string
     */
    private $encoded;

    /**
     * Password constructor.
     * @param string $salt
     * @param string $encoded
     */
    public function __construct(string $salt, string $encoded)
    {
        $this->salt = $salt;
        $this->encoded = $encoded;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getEncoded(): string
    {
        return $this->encoded;
    }

    /**
     * @param string $encoded
     */
    public function setEncoded(string $encoded)
    {
        $this->encoded = $encoded;
    }
}

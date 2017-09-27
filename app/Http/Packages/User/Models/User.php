<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 5:39 PM
 */

namespace App\Http\Packages\User\Models;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * Class User
 * @package App\Http\Packages\User\Models
 */
class User implements JsonSerializable, Arrayable
{
    /**
     * @var int
     */
    private $user_id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone_number;

    /**
     * @var string
     */
    private $full_name;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $account_key;

    /**
     * @var string
     */
    private $metadata;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber(string $phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     */
    public function setFullName(string $full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getAccountKey(): string
    {
        return $this->account_key;
    }

    /**
     * @param string $account_key
     */
    public function setAccountKey(string $account_key)
    {
        $this->account_key = $account_key;
    }

    /**
     * @return string
     */
    public function getMetadata(): string
    {
        return $this->metadata;
    }

    /**
     * @param string $metadata
     */
    public function setMetadata(string $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @param $row
     */
    public function extractRow($row)
    {
        //Lets us accept either an array or stdClass.
        $row = (array)$row;

        $this->user_id      = $row['user_id'];
        $this->email        = $row['email'];
        $this->phone_number = $row['phone_number'];
        $this->full_name    = $row['full_name'];
        $this->password     = $row['password'];
        $this->key          = $row['key'];
        $this->account_key  = isset($row['account_key']) ? $row['account_key']: null;
        $this->metadata     = $row['metadata'];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'email'        => $this->email,
            'phone_number' => $this->phone_number,
            'full_name'    => $this->full_name,
            'key'          => $this->key,
            'account_key'  => $this->account_key,
            'metadata'     => $this->metadata,
        );
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }
}

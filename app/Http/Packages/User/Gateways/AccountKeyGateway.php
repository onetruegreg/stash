<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 10:35 AM
 */

namespace App\Http\Packages\User\Gateways;

use App\Http\Packages\User\Models\User;
use App\Http\Packages\Utils\HttpClients\ClientInterface;

/**
 * Class AccountKeyGateway
 * @package App\Http\Packages\User\Gateways
 */
class AccountKeyGateway
{
    const URL = 'https://account-key-service.herokuapp.com/v1/account';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * AccountKeyGateway constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getAccountKeyForUser(User $user)
    {
        $headers = array(
            'Content-Type' => 'application/json'
        );
        $body = array(
            'email' => $user->getEmail(),
            'key' => $user->getKey(),
        );
        return $this->client->request('POST', self::URL, $headers, $body);
    }
}

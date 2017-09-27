<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 10:14 PM
 */

namespace App\Http\Packages\Utils\HttpClients;

/**
 * Interface ClientInterface
 * @package App\Http\Packages\Utils\HttpClients
 */
interface ClientInterface
{
    /**
     * @param $verb
     * @param $url
     * @param $headers
     * @param $body
     * @return array
     */
    public function request($verb, $url, $headers, $body): array;
}

<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 10:14 PM
 */

namespace App\Http\Packages\Utils\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Log;

/**
 * Creating this wrapper class lets us implement an interface so we can change http clients if need be.
 *
 * Class GuzzleClient
 * @package App\Http\Packages\Utils\HttpClients
 */
class GuzzleClient implements ClientInterface
{
    private $client;

    /**
     * GuzzleClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $verb
     * @param $url
     * @param $headers
     * @param $body
     * @return array
     */
    public function request($verb, $url, $headers, $body): array
    {
        /**
         * In a perfect world this Request object has an interface as well and all the other clients make their own
         * versions of it that gets passed into this method but I don't want to go crazy doing it for every aspect of
         * the client when I feel like this serves my purposes and I made my point about interfaces and dependency
         * injection.
         *
         * This also gives us a place to log stuff without it clogging up our business layer classes.
         */
        $request = new Request($verb, $url, $headers, json_encode($body));

        Log::info(
            '[GuzzleClient Request]: ' . print_r(
                array(
                    'verb'    => $verb,
                    'url'     => $url,
                    'headers' => $headers,
                    'body'    => $body,
                    ),
                true
            )
        );


        $response = $this->client->send($request);
        Log::info('[GuzzleClient Response]: ' . print_r($response, true));

        /**
         * I'd probably make a ResponseInterface and return that instead of an array too with a get->Json() function
         * rather than use the ugliness of json_decode(string, true)
         */
        return json_decode($response->getBody(), true);
    }
}

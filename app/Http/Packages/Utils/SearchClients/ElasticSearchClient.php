<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 12:38 AM
 */

namespace App\Http\Packages\Utils\SearchClients;

use App;
use Elasticsearch\Client;
use Log;

/**
 * Class ElasticSearchClient
 * @package App\Http\Packages\Utils\SearchClients
 */
class ElasticSearchClient implements SearchClientInterface
{
    /**
     * @var Client
     */
    private $elasticSearch;

    /**
     * ElasticSearchClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->elasticSearch = $client;
    }

    /**
     * @param array $params
     * @return array
     */
    public function index(array $params): array
    {
        //ElasticSearch is only near real-time. In a testing environment block until the data is available.
        if (App::environment() == 'testing') {
            $params['refresh'] = true;
        }
        Log::info('[ElasticSearch/' . $params['index'] . '/' . $params['type'] . ' Index Request]: ' . print_r($params, true));
        $response = $this->elasticSearch->index($params);
        Log::info('[ElasticSearch/' . $params['index'] . '/' . $params['type'] . '  Index Response]: ' . print_r($response, true));
        return $response;
    }

    /**
     * @param array $params
     * @return array
     */
    public function search(array $params): array
    {
        //Lower log level here since there is no state change from a search.
        Log::debug('[ElasticSearch/' . $params['index'] . '/' . $params['type'] . ' Index Request]: ' . print_r($params, true));
        $response = $this->elasticSearch->search($params);
        Log::debug('[ElasticSearch/' . $params['index'] . '/' . $params['type'] . '  Index Response]: ' . print_r($response, true));
        return $response;
    }

    /**
     * @param $index
     * @return array
     */
    public function deleteIndex($index): array
    {
        $params = array('index' => $index);
        return $this->elasticSearch->indices()->delete($params);
    }
}

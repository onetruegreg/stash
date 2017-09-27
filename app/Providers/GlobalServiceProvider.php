<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 10:15 PM
 */

namespace App\Providers;

use App;
use App\Http\Packages\Utils\HttpClients\ClientInterface;
use App\Http\Packages\Utils\HttpClients\GuzzleClient;
use App\Http\Packages\Utils\SearchClients\ElasticSearchClient;
use App\Http\Packages\Utils\SearchClients\SearchClientInterface;
use Elasticsearch\ClientBuilder;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

/**
 * Dumping ground for extremely ubiquitous bindings that don't belong to a specific package.
 *
 * Class GlobalServiceProvider
 * @package App\Providers
 */
class GlobalServiceProvider extends ServiceProvider
{
    /**
     * @return array
     */
    public function provides()
    {
        return array(
            ClientInterface::class,
            SearchClientInterface::class,
        );
    }

    /**
     *
     */
    public function register()
    {
        //I like Guzzle but if we ever decided not to use it we can change it easily here since we're using an interface.
        $this->app->bind(ClientInterface::class, function($app){
            $client = new Client();
            return new GuzzleClient($client);
        });

        $this->app->bind(SearchClientInterface::class, function($app){
            $client = ClientBuilder::create()->build();
            $client = new ElasticSearchClient($client);
            return $client;
        });
    }

    /**
     * @return ClientInterface
     */
    public static function getHttpClient()
    {
        return App::make(ClientInterface::class);
    }

    /**
     * @return SearchClientInterface
     */
    public static function getSearchClient()
    {
        return App::make(SearchClientInterface::class);
    }
}

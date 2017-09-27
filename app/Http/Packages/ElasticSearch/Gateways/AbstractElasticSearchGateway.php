<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 10:13 AM
 */

namespace App\Http\Packages\ElasticSearch\Gateways;

use App;
use App\Http\Packages\Utils\SearchClients\SearchClientInterface;

/**
 * Class AbstractElasticSearchGateway
 * @package App\Http\Packages\ElasticSearch\Gateways
 */
abstract class AbstractElasticSearchGateway
{
    /**
     * @var SearchClientInterface
     */
    protected $searchClient;

    /**
     * UserSearchGateway constructor.
     * @param SearchClientInterface $client
     */
    public function __construct(SearchClientInterface $client)
    {
        $this->searchClient = $client;
    }

    /**
     * @return string
     */
    protected function getIndexSuffix(): string
    {
        /**
         * Laravel will point MySQL to a separate test DB but not ElasticSearch. This does the equivalent.
         */
        if (App::environment() == 'testing') {
            return '_testing';
        } else {
            return '';
        }
    }

    /**
     * This is boilerplate for every ElasticSearch query and forces implementations to use test indexes for the testing
     * environment.
     *
     * @return array
     */
    protected function makeBaseQuery()
    {
        $params =  array(
            'index' => $this->getIndex(),
            'type' => $this->getType(),
        );
        return $params;
    }

    /**
     * Your implementation should return a constant for the index name with the output of getIndexSuffix() appended
     * to the end of it.
     *
     * @return string
     */
    protected abstract function getIndex(): string;

    /**
     * Your implementation should just return the type name.
     *
     * @return string
     */
    protected abstract function getType(): string;

}
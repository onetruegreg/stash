<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 2:20 AM
 */

namespace database\seeds;


use App\Http\Packages\Utils\SearchClients\ElasticSearchClient;
use App\Providers\GlobalServiceProvider;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticSearchTestSetup
{
    /**
     * @var ElasticSearchClient
     */
    private $elasticSearch;

    /**
     * ElasticSearchTestSetup constructor.
     */
    public function __construct()
    {
        $this->elasticSearch = GlobalServiceProvider::getSearchClient();
    }

    /**
     *
     */
    public function setupElasticSearch()
    {
        $this->deleteIndexes();
    }

    /**
     *
     */
    private function deleteIndexes()
    {
        $indexesToDelete = array(
            'user_search_testing'
        );
        foreach ($indexesToDelete as $index) {
            try {
                $this->elasticSearch->deleteIndex($index);
            } catch (Missing404Exception $e) {
                //Who cares?
            }
        }
    }
}
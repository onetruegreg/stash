<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 12:24 AM
 */

namespace App\Http\Packages\User\Gateways;

use App;
use App\Http\Packages\ElasticSearch\Gateways\AbstractElasticSearchGateway;
use App\Http\Packages\User\Models\User;

/**
 * UserGateway is only responsible for querying MySQL and outputting User objects. This class is only responsible for
 * querying the search service, which in our case is only ElasticSearch.
 *
 * Class UserSearchGateway
 * @package app\Http\Packages\User\Gateways
 */
class UserSearchGateway extends AbstractElasticSearchGateway
{
    const INDEX = 'user_search';
    const TYPE = 'user';

    /**
     * @param User $user
     * @return array
     */
    public function indexUser(User $user)
    {
        $params = $this->makeBaseQuery();
        $params['id'] = $user->getUserId();
        $params['body'] = $this->makeBody($user);
        $response = $this->searchClient->index($params);
        return $response;
    }

    /**
     * Returns an array of IDs matching the query.
     *
     * @param $keyword
     * @return array
     */
    public function search($keyword)
    {
        $params = $this->makeBaseQuery();
        $params['body']['query']['multi_match']['query'] = $keyword;
        //Lets the query mismatch by one or two characters which is pretty cool! Doesn't activate on short querys.
        $params['body']['query']['multi_match']['fuzziness'] = 'AUTO';
        $params['body']['query']['multi_match']['fields'] = $this->getSearchFields();
        $response = $this->searchClient->search($params);
        $ids = array();
        /**
         * Normally I would take this response and build a response bean out of it that keeps more of the data, but
         * time is limited and the IDs are all we need for this project.
         */
        foreach ($response['hits']['hits'] as $hit) {
            $ids[] = $hit['_id'];
        }
        return $ids;
    }

    /**
     * Get the index name appropriate for the current environment.
     *
     * @return string
     */
    protected function getIndex(): string
    {
        return self::INDEX . $this->getIndexSuffix();
    }

    /**
     * @return string
     */
    protected function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @param User $user
     * @return array
     */
    private function makeBody(User $user): array
    {
        return array(
            'email'     => $user->getEmail(),
            'full_name' => $user->getFullName(),
            'metadata'  => $user->getMetadata(),
        );
    }

    /**
     * @return array
     */
    private function getSearchFields()
    {
        return array(
            'email',
            'full_name',
            'metadata'
        );
    }
}

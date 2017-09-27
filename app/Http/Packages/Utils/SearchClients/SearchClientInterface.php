<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 12:38 AM
 */

namespace App\Http\Packages\Utils\SearchClients;

/**
 * Interface SearchClientInterface
 * @package App\Http\Packages\Utils\SearchClients
 */
interface SearchClientInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function index(array $params): array;

    /**
     * @param array $params
     * @return array
     */
    public function search(array $params): array;

    /**
     * @param $index
     * @return array
     */
    public function deleteIndex($index): array;
}

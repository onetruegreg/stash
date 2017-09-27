<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 1:40 AM
 */

namespace App\Http\Packages\User\Tests;

use database\seeds\ElasticSearchTestSetup;
use Tests\TestCase;

/**
 * I could do a bunch of unit tests for each of the gateways and components and stuff, and that would be the proper
 * thing to do as this grows, but for this relatively simple project just testing each gateway function would be a
 * massive repetition of what we're doing here.
 *
 * Class UserControllerTest
 * @package App\Http\Packages\User\Tests
 */
class UserControllerTest extends TestCase
{
    const JOHNNY_KEY = '28ede3e46155ad82e0c34fe151dc6e568392875c';
    const ZIM_KEY    = '17e719d8d19e5c3fae034ef6824a35b5b711493e';

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->seed('TruncateListedTablesSeeder');
        $elasticSearchSeeder = new ElasticSearchTestSetup();
        $elasticSearchSeeder->setupElasticSearch();
    }

    /**
     * @group User
     */
    public function testCreateUser()
    {
        $body = $this->getJohnny();
        $headers = $this->getHeaders();
        $response = $this->json('POST', 'api/v1/users', $body, $headers);
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($body['email']           , $response['user']['email']);
        $this->assertEquals($body['full_name']       , $response['user']['full_name']);
        $this->assertEquals($body['phone_number']    , $response['user']['phone_number']);
        $this->assertEquals($body['metadata']        , $response['user']['metadata']);
        $this->assertEquals(self::JOHNNY_KEY, $response['user']['key']);
    }

    /**
     * @group User
     */
    public function testCreateDuplicateUser()
    {
        $body = $this->getJohnny();
        $headers = $this->getHeaders();

        //Check duplicate email error.
        $this->json('POST', 'api/v1/users', $body, $headers);
        $response = $this->json('POST', 'api/v1/users', $body, $headers);
        $response = json_decode($response->getContent(), true);
        $this->assertTrue(isset($response['errors']['email']));

        //Different emails, check duplicate phone number error.
        $this->refreshApplication();
        $body['email'] = 'dflores@mobileinfantry.mil';
        $response = $this->json('POST', 'api/v1/users', $body, $headers);
        $response = json_decode($response->getContent(), true);
        $this->assertTrue(isset($response['errors']['phone_number']));
    }

    /**
     * @group User
     */
    public function testSearchUser()
    {
        $body = $this->getJohnny();
        $headers = $this->getHeaders();

        $this->json('POST', 'api/v1/users', $body, $headers);
        $this->refreshApplication();

        $body = $this->getZim();
        $this->json('POST', 'api/v1/users', $body, $headers);
        $this->refreshApplication();

        $response = $this->json('GET', 'api/v1/users?query=zim', $body, $headers);
        $response = json_decode($response->getContent(), true);

        //account_key shouldn't be set yet since it is generated in a separate job.
        $this->assertEquals(1            , count($response['users']));
        $this->assertEquals($body['email']        , $response['users'][0]['email']);
        $this->assertEquals($body['full_name']    , $response['users'][0]['full_name']);
        $this->assertEquals($body['phone_number'] , $response['users'][0]['phone_number']);
        $this->assertEquals($body['metadata']     , $response['users'][0]['metadata']);
        $this->assertEquals(self::ZIM_KEY, $response['users'][0]['key']);
    }

    /**
     * @group User
     */
    public function testGetAllUsers()
    {
        $johnny = $this->getJohnny();
        $headers = $this->getHeaders();

        $this->json('POST', 'api/v1/users', $johnny, $headers);
        $this->refreshApplication();

        $zim = $this->getZim();
        $this->json('POST', 'api/v1/users', $zim, $headers);
        $this->refreshApplication();

        $response = $this->json('GET', 'api/v1/users', array(), $headers);
        $response = json_decode($response->getContent(), true);

        //Just make sure we fetched them all. The other cases check the full values.
        $this->assertEquals(2, count($response['users']));
        //Since this is a second call we can expect account_key to be set.
        $this->assertTrue(isset($response['users'][0]['account_key']));
    }

    /**
     * @return array
     */
    private function getHeaders()
    {
        return array(
            'Content-Type'     => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        );
    }

    /**
     * Might normally make a seeder to set these guys up, but we're also testing the process of saving them.
     *
     * @return array
     */
    private function getJohnny()
    {
        return array(
            'email' => 'jrico@mobileinfantry.mil',
            'full_name' => 'Juan "Johnny" Rico',
            'phone_number' => '123-456-7890',
            'password' => 'imdoingmypart',
            'metadata' => 'Aliases: John, Johnny, Johnnie; Gender: Male; Occupation: Soldier; Nationality: Argentine;',
        );
    }

    /**
     * @return array
     */
    private function getZim()
    {
        return array(
            'email' => 'czim@mobileinfantry.mil',
            'full_name' => 'Charles "Charlie" Zim',
            'phone_number' => '456-456-7890',
            'password' => 'roughneck',
            'metadata' => 'John Rico\'s boot-camp training instructor and a company commander at Camp Currie.',
        );
    }
}

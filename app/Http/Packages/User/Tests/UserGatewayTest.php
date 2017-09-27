<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 11:58 AM
 */

namespace App\Http\Packages\User\Tests;

use App\Http\Packages\User\Gateways\UserGateway;
use App\Http\Packages\User\Gateways\UserSearchGateway;
use App\Http\Packages\User\Models\Password;
use App\Http\Packages\User\Security\KeyGenerator;
use App\Http\Packages\User\Security\PasswordEncoder;
use Mockery;
use Tests\TestCase;

/**
 * Class UserGatewayTest
 * @package App\Http\Packages\User\Tests
 */
class UserGatewayTest extends TestCase
{
    /**
     * This isn't an exhaustive test, but I wanted to show the power of dependency injection with Mockery. Here we can
     * instantiate a gateway with 3 different dependencies and unit test only that gateway without actually
     * instantiating any of the dependencies. For testing with external services this can be mandatory.
     *
     * @group User
     */
    public function testSaveAndSearch()
    {
        /** @var KeyGenerator $keyGenerator */
        $keyGenerator = Mockery::mock(KeyGenerator::class, array(
            'makeKey' => 'aa8453829ffd0c213d26e5f6da1c8e505a03ddd0',
        ));

        $password = new Password(
            'mejl6tlbXV2A2UhefJ93GDy967pbXhQR',
            'e5057ee45e25037a91295fb9b8f6535170cf8f6281a1d444c8dc5b457317d0e8'
        );

        /** @var PasswordEncoder $passwordEncoder*/
        $passwordEncoder = Mockery::mock(PasswordEncoder::class, array(
            'encode' => $password,
        ));

        /** @var UserSearchGateway $searchGateway */
        $searchGateway = Mockery::mock(UserSearchGateway::class, array(
            'search' => array(1337),
        ));
        $gateway = new UserGateway($keyGenerator, $passwordEncoder, $searchGateway);
        $gateway->createUser($this->getElodin());
        $result = $gateway->getUsers('Arcanist');
        $this->assertEquals(1, count($result));
    }

    /**
     * @return array
     */
    private function getElodin()
    {
        return array(
            'user_id' => 1337, //Specify the ID here so it doesn't overlap with other tests.
            'email' => 'elodin@theuniversity.edu',
            'full_name' => 'Master Elodin',
            'phone_number' => '222-222-2222',
            'password' => 'SeaInStormNightWithNoMoonAngerOfAGentleMan',
            'metadata' => 'Master Elodin was an exceptionally brilliant student and also the youngest to have ever been 
                admitted to the University, at the age of 14. By the time he turned 18, he had become a Full Arcanist 
                and began working as a Giller. He continued on to become Master Namer and then Chancellor of the 
                University, though this was short lived.',
        );
    }
}
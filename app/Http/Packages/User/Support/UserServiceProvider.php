<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 5:16 PM
 */

namespace App\Http\Packages\User\Support;

use App;
use App\Http\Packages\User\Gateways\AccountKeyGateway;
use App\Http\Packages\User\Gateways\UserGateway;
use App\Http\Packages\User\Gateways\UserSearchGateway;
use App\Http\Packages\User\Security\KeyGenerator;
use App\Http\Packages\User\Security\PasswordEncoder;
use App\Providers\GlobalServiceProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class UserServiceProvider
 * @package App\Http\Packages\User\Support
 */
class UserServiceProvider extends ServiceProvider
{
    /**
     * @return array
     */
    public function provides()
    {
        return array(
            UserGateway::class,
            UserSearchGateway::class,
            AccountKeyGateway::class,
        );
    }

    /**
     *
     */
    public function register()
    {
        $this->app->singleton(UserGateway::class, function($app){
                $keyGenerator = new KeyGenerator();
                $passwordEncoder = new PasswordEncoder();
                $searchGateway = self::getUserSearchGateway();
                return new UserGateway($keyGenerator, $passwordEncoder, $searchGateway);
            }
        );

        $this->app->singleton(UserSearchGateway::class, function($app){
                $client = GlobalServiceProvider::getSearchClient();
                return new UserSearchGateway($client);
            }
        );

        $this->app->bind(AccountKeyGateway::class, function($app){
                $client = GlobalServiceProvider::getHttpClient();
                return new AccountKeyGateway($client);
            }
        );
    }

    /**
     * @return UserGateway
     */
    public static function getUserGateway()
    {
        return App::make(UserGateway::class);
    }

    /**
     * @return UserSearchGateway
     */
    public static function getUserSearchGateway()
    {
        return App::make(UserSearchGateway::class);
    }

    /**
     * @return AccountKeyGateway
     */
    public static function getAccountKeyGateway()
    {
        return App::make(AccountKeyGateway::class);
    }
}

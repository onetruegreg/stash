<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 4:55 PM
 */

namespace App\Http\Packages\User\Gateways;

use App\Http\Packages\User\Jobs\IndexUserInElasticSearch;
use App\Http\Packages\User\Models\User;
use App\Http\Packages\User\Security\KeyGeneratorInterface;
use App\Http\Packages\User\Security\PasswordEncoderInterface;
use App\Http\Packages\User\Jobs\FetchAccountKey;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

/**
 * Class UserGateway
 * @package App\Http\Gateways
 */
class UserGateway
{
    use DispatchesJobs;

    /**
     * @var KeyGeneratorInterface
     */
    private $keyGenerator;

    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var UserSearchGateway
     */
    private $searchGateway;

    /**
     * UserGateway constructor.
     * @param KeyGeneratorInterface $keyGenerator
     * @param PasswordEncoderInterface $passwordEncoder
     * @param UserSearchGateway $searchGateway
     */
    public function __construct(KeyGeneratorInterface $keyGenerator, PasswordEncoderInterface $passwordEncoder, UserSearchGateway $searchGateway)
    {
        $this->keyGenerator    = $keyGenerator;
        $this->passwordEncoder = $passwordEncoder;
        $this->searchGateway   = $searchGateway;
    }

    /**
     * @param array $row
     * @return User
     */
    public function createUser(array $row)
    {
        $row['key'] = $this->keyGenerator->makeKey($row);
        $password = $this->passwordEncoder->encode($row['password']);
        $row['password'] = $password->getEncoded();
        //Save the salt so we can validate against it on a login attempt.
        $row['salt'] = $password->getSalt();

        $id = $this->db()->insertGetId($row);
        $row['user_id'] = $id;

        $user = new User();
        $user->extractRow($row);

        $this->queueCreationJobs($user);

        return $user;
    }

    /**
     * @param null $keyword
     * @return User[]
     */
    public function getUsers($keyword = null)
    {
        $users = array();
        $sql = $this->db()->select()->orderBy('time_created', 'desc');
        if ($keyword) {
            $ids = $this->searchGateway->search($keyword);
            $sql->whereIn('user_id', $ids);
        }
        $rows = $sql->get();
        foreach ($rows as $row) {
            $user = new User();
            $user->extractRow((array)$row);
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @param $email
     * @param $accountKey
     * @return int
     */
    public function saveAccountKey($email, $accountKey)
    {
        $row = array(
            'account_key' => $accountKey,
        );
        return $this->db()
            ->where('email', '=', $email)
            ->update($row);
    }

    /**
     * @param User $user
     */
    private function queueCreationJobs(User $user)
    {
        /**
         * This will deploy an asynchronous job that can be retried a limited number of times accounting for the
         * unreliability of third party and external services.
         */
        $this->dispatch(new FetchAccountKey($user));
        $this->dispatch(new IndexUserInElasticSearch($user));
    }

    /**
     * This query builder will automatically protect against SQL injection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function db()
    {
        return DB::table('user');
    }
}

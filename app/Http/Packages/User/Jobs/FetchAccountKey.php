<?php

namespace App\Http\Packages\User\Jobs;

use App\Http\Packages\User\Models\User;
use App\Http\Packages\User\Support\UserServiceProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class FetchAccountKey
 * @package App\Http\Packages\User\Jobs
 */
class FetchAccountKey implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * FetchAccountKey constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = UserServiceProvider::getAccountKeyGateway()->getAccountKeyForUser($this->user);
        UserServiceProvider::getUserGateway()->saveAccountKey($response['email'], $response['account_key']);
    }
}

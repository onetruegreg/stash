<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 8:41 PM
 */

namespace App\Http\Packages\User\Security;

use App\Http\Packages\User\Models\Password;

/**
 * This lets us change out the password encoding algorithm easily in the future.
 *
 * Interface PasswordEncoderInterface
 * @package App\Http\Packages\User\Security
 */
interface PasswordEncoderInterface
{
    /**
     * @param string $password
     * @return Password
     */
    public function encode(string $password): Password;
}

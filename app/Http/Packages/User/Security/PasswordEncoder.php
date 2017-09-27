<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 8:47 PM
 */

namespace App\Http\Packages\User\Security;

use App\Http\Packages\User\Models\Password;

/**
 * Class PasswordEncoder
 * @package app\Http\Packages\User\Security
 */
class PasswordEncoder implements PasswordEncoderInterface
{
    //The higher the more secure but the slower. Don't ever change this though because old accounts won't authenticate.
    const ITERATIONS = 1337;

    //This maps to the DB VarChar size.
    const SALT_LENGTH = 32;

    /**
     * @param string $password
     * @return Password
     */
    public function encode(string $password): Password
    {
        $salt = $this->makeSalt();
        $encoded = hash_pbkdf2('gost-crypto', $password, $salt, self::ITERATIONS);
        return new Password($salt, $encoded);
    }

    /**
     * In php the most secure function to generate a random string is random_bytes(), but since we need to store the
     * salt in the DB we're limited by the DB charset. Instead we use the similarly secure random_int and convert the
     * result into our predefined character set of [a-z, A-Z, 0-9]
     *
     * Some problems aren't worth solving twice.
     *
     * @see https://stackoverflow.com/questions/36970690/random-string-in-php7
     * @return string
     */
    private function makeSalt()
    {
        $lower = range('a', 'z');
        $caps = range('A', 'Z');
        $nums = range (0, 9);

        $charSet = array_merge($lower, $caps, $nums);
        $count = count($charSet);

        $salt = '';
        for ($i = 0; $i < self::SALT_LENGTH; $i++)
        {
            //Get a random number within the bounds of our charSet and cat the corresponding char.
            $salt .= $charSet[random_int(0, $count - 1)];
        }

        return $salt;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 8:31 PM
 */

namespace App\Http\Packages\User\Security;

/**
 * This lets us change out the keymaking algorithm easily in the future.
 *
 * Interface KeyGeneratorInterface
 * @package App\Http\Packages\User\Security
 */
interface KeyGeneratorInterface
{
    /**
     * @param array $row
     * @return string
     */
    public function makeKey(array $row): string;
}

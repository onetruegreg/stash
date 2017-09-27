<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 8:31 PM
 */

namespace App\Http\Packages\User\Security;

/**
 * Class KeyGenerator
 * @package App\Http\Packages\User\Security
 */
class KeyGenerator implements KeyGeneratorInterface
{
    const SECRET = 'IK0LxYTPpxz75RSN7LJN';

    /**
     * @param array $row
     * @return string
     */
    public function makeKey(array $row): string
    {
        /**
         * Since these fields are of limited length a sha1 collision should be as close to impossible as is reasonable
         * to worry about. Just email would be too obvious so we'll grab 2 fields and salt one by XORing it with a
         * secret random string.
         */
        return sha1($row['email'] . ($row['full_name'] ^ self::SECRET));
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/18/17
 * Time: 2:18 AM
 */

use Illuminate\Database\Seeder;

/**
 * Class TruncateListedTablesSeeder
 */
class TruncateListedTablesSeeder extends Seeder
{
    /**
     * Remove all old test values to return the datbase to a fresh state..
     *
     * @return void
     */
    public function run()
    {
        $tablesToTruncate = array(
            'user'
        );
        foreach ($tablesToTruncate as $table) {
            DB::table($table)->truncate();
        }
    }
}
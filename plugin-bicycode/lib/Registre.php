<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 23/06/2017
 * Time: 01:54
 */

namespace Garradin\Plugin\Bicycode;


use Garradin\DB;

class Registre
{
    public function __construct()
    {

    }

    public function addBicycode($code)
    {
        $data = "";

        $db = DB::getInstance(true);
        $db->simpleInsert('plugin_bicycode', $data);
    }

    public function delBicycode($code)
    {

    }

    public function getBicycode($code = "")
    {
        $db = DB::getInstance(true);
        if(isset($code))
        {
            return $db->simpleQuerySingle('SELECT * FROM plugin_bicycode WHERE id = ?;', true, (int) $code);
        }
        return $db->simpleQuerySingle('SELECT * FROM plugin_bicycode;',
            true);
    }

}
?>
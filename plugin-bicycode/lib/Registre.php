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

    public function addBicycode($data)
    {
        $db = DB::getInstance(true);
        $db->simpleInsert('plugin_bicycode', $data);
    }

    public function delBicycode($code)
    {

    }

    public function getBicycode($code = NULL)
    {
        $db = DB::getInstance(true);

        if($code == !NULL)
        {
            $requete = "SELECT * FROM plugin_bicycode WHERE id = ".(int)$code;
        }
        else
        {
            $requete = "SELECT * FROM plugin_bicycode";
        }
        return $db->queryFetch($requete);
    }

}
?>
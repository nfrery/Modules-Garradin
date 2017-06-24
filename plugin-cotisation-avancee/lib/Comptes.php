<?php
namespace Garradin\Plugin\Cotisation;

use Garradin;
use Garradin\Config;
use Garradin\DB;
use Garradin\UserException;
use Garradin\Utils;

const NUMERO_PARENT_COMPTES = 467;

class Comptes
{

    public function __construct()
    {

    }

    public function getList($parent = false)
    {
        $db = DB::getInstance();
        return $db->simpleStatementFetchAssocKey('SELECT c.id AS id, * FROM compta_comptes AS c
            WHERE c.parent = '.NUMERO_PARENT_COMPTES.' ORDER BY c.id;');
    }

}
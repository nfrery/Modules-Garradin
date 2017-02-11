<?php
namespace Garradin\Plugin\RecuDon;

use Garradin\DB;
use Garradin\UserException;

class GenDon
{

    public function __construct()
    {

    }

    public function add($data)
    {
        //$this->_checkData($data);

        /*if (!isset($data['numero']) == !trim($data['numero'])) {
            throw new UserException('Le numéro d ordre existe déjà sur un autre reçu.');
        }*/

        $db = DB::getInstance();
        $db->simpleInsert('plugin_recudon', $data);

        return $db->lastInsertRowID();
    }

    public function edit($id, $data)
    {
        //$this->_checkData($data);

        $db = DB::getInstance();
        return $db->simpleUpdate('plugin_recudon', $data, 'id = ' . (int) $id);
    }

    public function get($id)
    {
        $db = DB::getInstance();

        return $db->simpleQuerySingle('SELECT * FROM plugin_recudon WHERE id = ?;',
            true, (int) $id);
    }

    public function remove($id)
    {
        $db = DB::getInstance();

        return $db->simpleExec('DELETE FROM plugin_recudon WHERE id = ?;', (int) $id);
    }

    public function listSimple()
    {
        $db = DB::getInstance();
        return $db->queryFetch('SELECT id, nom, prenom, ville, "date", gen_ordre, montant FROM plugin_recudon ORDER BY id;');
    }
}
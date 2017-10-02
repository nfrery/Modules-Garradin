<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 28/09/2017
 * Time: 15:48
 */

namespace Garradin\Plugin\Benevolat;

use Garradin\DB;
use Garradin\UserException;

class BD
{
    public function __construct()
    {

    }

    public function addBenevolat($data)
    {
        $db = DB::getInstance(true);
        $db->simpleInsert('plugin_benevolat_enregistrement', $data);
    }

    public function removeBenevolat($id)
    {
        $db = DB::getInstance();
        $db->simpleExec("DELETE FROM plugin_benevolat_enregistrement WHERE id = ?;",(int)$id);
        return true;
    }

    public function addCategorie($data)
    {
        $db = DB::getInstance(true);
        $db->simpleInsert('plugin_benevolat_categorie', $data);
    }

    public function editCategorie($id, $data)
    {
        $db = DB::getInstance();
        $db->simpleUpdate('plugin_benevolat_categorie', $data, 'id = \''.trim($id).'\'');
        return true;
    }

    public function removeCategorie($id)
    {
        $db = DB::getInstance();

        if($db->simpleQuerySingle('SELECT 1 FROM plugin_benevolat_enregistrement WHERE id_categorie = ? LIMIT 1;',false, $id))
        {
            throw new UserException('Cette catégorie ne peut être supprimée car des contributions bénévoles y sont associées.');
        }

        $db->simpleExec("DELETE FROM plugin_benevolat_categorie WHERE id = ?;",(int)$id);
        return true;
    }

    public function getEnregistrement($id)
    {
        $db = DB::getInstance();
        return $db->simpleQuerySingle("SELECT ben.*,
            (SELECT SUBSTR(ben.description,0,50)) AS description_courte,
            (SELECT nom FROM membres WHERE id = ben.id_membre) AS nom,
            (SELECT taux_horaire FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS taux_horaire,
            (SELECT nom FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS categorie
            FROM plugin_benevolat_enregistrement AS ben WHERE id = :id;", true, $id);
    }

    public function getCategorie($id)
    {
        $db = DB::getInstance();
        return $db->simpleQuerySingle("SELECT * FROM plugin_benevolat_categorie WHERE id = :id;", true, $id);
    }

    public function getEnregistrements()
    {
        $db = DB::getInstance();
        return $db->simpleStatementFetch("SELECT ben.*,
            (SELECT SUBSTR(ben.description,0,50)) AS description_courte,
            (SELECT nom FROM membres WHERE id = ben.id_membre) AS nom,
            (SELECT taux_horaire FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS taux_horaire,
            (SELECT nom FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS categorie
            FROM plugin_benevolat_enregistrement AS ben;");
    }

    public function getLastsEnregistrements()
    {
        $db = DB::getInstance();
        return $db->simpleStatementFetch("SELECT ben.*,
            (SELECT SUBSTR(ben.description,0,50)) AS description_courte,
            (SELECT nom FROM membres WHERE id = ben.id_membre) AS nom,
            (SELECT taux_horaire FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS taux_horaire,
            (SELECT nom FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS categorie
            FROM plugin_benevolat_enregistrement AS ben ORDER BY id DESC LIMIT 5;");
    }

    public function getStatsCategorie($id)
    {
        $db = DB::getInstance();
        return $db->simpleQuerySingle("SELECT cat.*,
            (SELECT SUM(heures) FROM plugin_benevolat_enregistrement WHERE id_categorie = cat.id) AS nb_heures
            FROM plugin_benevolat_categorie AS cat WHERE id = :id;", true, ['id' => (int) $id]);
    }

    public function getEnregistrementsCategorie($id)
    {
        $db = DB::getInstance();
        return $db->simpleStatementFetch("SELECT ben.*,
            (SELECT nom FROM membres WHERE id = ben.id_membre) AS nom,
            (SELECT taux_horaire FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS taux_horaire,
            (SELECT nom FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS categorie
            FROM plugin_benevolat_enregistrement AS ben
            WHERE id_categorie = :id;",true,['id' => (int) $id]);
    }

    public function getListeCategories()
    {
        $db = DB::getInstance();
        return $db->simpleStatementFetch("SELECT cat.*,
            (SELECT TOTAL(heures) FROM plugin_benevolat_enregistrement WHERE id_categorie = cat.id) AS nb_heures
            FROM plugin_benevolat_categorie AS cat;");
    }

}
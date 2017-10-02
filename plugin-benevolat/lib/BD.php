<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 28/09/2017
 * Time: 15:48
 */

namespace Garradin\Plugin\Benevolat;

use Garradin\DB;
use Garradin\Utils;
use Garradin\Compta\Journal;
use Garradin\UserException;

class BD
{
    public function __construct()
    {

    }

    protected function _checkFieldsContribution(&$data)
    {
        $db = DB::getInstance();

        if (empty($data['date']) || !Utils::checkDate($data['date']))
        {
            throw new UserException('Date vide ou invalide.');
        }

        if (!$db->simpleQuerySingle('SELECT 1 FROM compta_exercices WHERE cloture = 0
            AND debut <= :date AND fin >= :date;', false, ['date' => $data['date']]))
        {
            throw new UserException('La date ne correspond pas à l\'exercice en cours.');
        }

        if (isset($data['id_categorie']))
        {
            if (!$db->simpleQuerySingle('SELECT 1 FROM plugin_benevolat_categorie WHERE id = ?;', false, (int)$data['id_categorie']))
            {
                throw new UserException('Catégorie inconnue.');
            }

            $data['id_categorie'] = (int)$data['id_categorie'];
        }
        else
        {
            throw new UserException('Une catégorie doit être spécifiée.');
        }

        return true;
    }

    protected function _checkFieldsCategorie(&$data)
    {
        if (empty($data['nom']) || !trim($data['nom']))
        {
            throw new UserException('Le nom de peut pas être vide.');
        }

        $data['nom'] = trim($data['nom']);

        return true;
    }

    public function addBenevolat($data)
    {
        $this->_checkFieldsContribution($data);
        $db = DB::getInstance();
        $e = new Journal();
        $data['id_exercice'] = $e->checkExercice();
        $db->simpleInsert('plugin_benevolat_enregistrement', $data);
        return true;
    }

    public function editContribution($id, $data)
    {
        $db = DB::getInstance();
        $this->_checkFieldsContribution($data);
        $db->simpleUpdate('plugin_benevolat_enregistrement', $data, 'id = \''.trim($id).'\'');
        return true;
    }

    public function removeBenevolat($id)
    {
        $db = DB::getInstance();
        $db->simpleExec("DELETE FROM plugin_benevolat_enregistrement WHERE id = ?;",(int)$id);
        return true;
    }

    public function getEnregistrement($id)
    {
        $db = DB::getInstance();
        return $db->simpleQuerySingle("SELECT ben.*,
            (SELECT SUBSTR(ben.description,0,50)) AS description_courte,
            (SELECT nom FROM membres WHERE id = ben.id_membre) AS nom,
            (SELECT nom FROM membres WHERE id = ben.id_membre_ajout) AS nom_membre_ajout,
            (SELECT nom FROM membres WHERE id = ben.id_membre_modif) AS nom_membre_modif,
            (SELECT taux_horaire FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS taux_horaire,
            (SELECT nom FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS categorie,
            (SELECT (taux_horaire * ben.heures) FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS valorise
            FROM plugin_benevolat_enregistrement AS ben WHERE id = :id;", true, $id);
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
            (SELECT nom FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS categorie,
            (SELECT (taux_horaire * ben.heures) FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS valorise
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
            (SELECT nom FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS categorie,
            (SELECT (taux_horaire * ben.heures) FROM plugin_benevolat_categorie WHERE id = ben.id_categorie) AS valorise
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
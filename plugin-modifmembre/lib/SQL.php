<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 28/09/2017
 * Time: 15:48
 */

namespace Garradin\Plugin\MODIFMEMBRE;

use Garradin\Config;
use Garradin\DB;
use Garradin\UserException;

class SQL
{
    public function __construct()
    {
    }

    function getMembreWithoutCotisation()
    {
        $db = DB::getInstance();
        $query = 'SELECT id,
			(julianday(date()) - julianday(expiration)) AS nb_jours
		FROM (
			SELECT m.*,
				CASE WHEN c.duree IS NOT NULL THEN date(cm.date, \'+\'||c.duree||\' days\')
				WHEN c.fin IS NOT NULL THEN c.fin ELSE 0 END AS expiration
			FROM cotisations AS c
				INNER JOIN cotisations_membres AS cm ON cm.id_cotisation = c.id
				INNER JOIN membres AS m ON m.id = cm.id_membre
			WHERE
				(c.fin IS NOT NULL OR c.duree IS NOT NULL)
				AND m.id_categorie NOT IN (SELECT id FROM membres_categories WHERE cacher = 1)
	    	GROUP BY m.id
		)
		WHERE nb_jours >= 548;';
        $membres = (array) $db->get($query);

        return $membres;
    }

    function changeCategorie($id)
    {
        $db = DB::getInstance();
        $db->update('membres',['id_categorie'=>'2'], $db->where('id', (int)$id));
    }

    public function modifCategorie()
    {
        $membres = $this->getMembreWithoutCotisation();

        foreach ($membres as $m)
        {
            $this->changeCategorie($m['id']);
        }

    }

}
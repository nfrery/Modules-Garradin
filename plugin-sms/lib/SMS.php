<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 28/09/2017
 * Time: 15:48
 */

namespace Garradin\Plugin\SMS;

use Garradin\Config;
use Garradin\DB;
use Garradin\Plugin;
use Garradin\Utils;
use Garradin\Compta\Journal;
use Garradin\UserException;
use Ovh\Sms\SmsApi;

class SMS
{
    public function __construct()
    {
        require 'vendor/autoload.php';
    }

    /**
     * Vérification des champs fournis pour la modification de donnée
     * @param  array $data Tableau contenant les champs à ajouter/modifier
     * @return void
     */
    protected function _checkFields(&$data)
    {
        $db = DB::getInstance();

        if (empty($data['id_cotisation'])
            || !$db->firstColumn('SELECT 1 FROM cotisations WHERE id = ?;', (int) $data['id_cotisation']))
        {
            throw new UserException('Cotisation inconnue.');
        }

        $data['id_cotisation'] = (int) $data['id_cotisation'];

        if ((trim($data['delai']) === '') || !is_numeric($data['delai']))
        {
            throw new UserException('Délai avant rappel invalide : doit être indiqué en nombre de jours.');
        }

        $data['delai'] = (int) $data['delai'];


        if (!isset($data['texte']) || trim($data['texte']) === '')
        {
            throw new UserException('Le contenu du rappel ne peut être vide.');
        }

        $data['texte'] = trim($data['texte']);

        /*
        if (!array_key_exists('id_rappel', $data)
            || (!is_null($data['id_rappel']) && (empty($data['id_rappel']) || !$db->firstColumn('SELECT 1 FROM rappels_sms WHERE id = ?;', (int) $data['id_rappel']))))
        {
            throw new \LogicException('ID rappel non fourni ou inexistant dans la table rappels');
        }*/

        if (isset($data['id_cotisation']))
        {
            if (!$db->firstColumn('SELECT 1 FROM cotisations WHERE id = ?;', (int) $data['id_cotisation']))
            {
                throw new UserException('Cotisation inconnue.');
            }

            $data['id_cotisation'] = (int) $data['id_cotisation'];
        }

        /*
        if (empty($data['id_membre'])
            || !$db->firstColumn('SELECT 1 FROM membres WHERE id = ?;', (int) $data['id_membre']))
        {
            throw new UserException('Membre inconnu.');
        }

        $data['id_membre'] = (int) $data['id_membre'];

        if (empty($data['media']) || !is_numeric($data['media'])
            || !in_array((int)$data['media'], [self::MEDIA_EMAIL, self::MEDIA_COURRIER, self::MEDIA_TELEPHONE, self::MEDIA_AUTRE]))
        {
            throw new UserException('Média invalide.');
        }

        $data['media'] = (int) $data['media'];

        if (empty($data['date']) || !Utils::checkDate($data['date']))
        {
            throw new UserException('La date indiquée n\'est pas valide.');
        }*/
    }

    /**
     * Ajouter un rappel
     * @param array $data Données du rappel
     * @return integer Numéro ID du rappel créé
     */
    public function add($data)
    {
        $db = DB::getInstance();

        $this->_checkFields($data);

        $db->insert('rappels_sms', $data);

        return $db->lastInsertRowId();
    }

    /**
     * Modifier un rappel automatique
     * @param  integer 	$id   Numéro du rappel
     * @param  array 	$data Données du rappel
     * @return boolean        TRUE si tout s'est bien passé
     * @throws UserException  En cas d'erreur dans une donnée à modifier
     */
    public function edit($id, $data)
    {
        $db = DB::getInstance();

        $this->_checkFields($data);

        return $db->update('rappels_sms', $data, 'id = ' . (int)$id);
    }

    /**
     * Supprimer un rappel automatique
     * @param  integer $id Numéro du rappel
     * @param  boolean $delete_history Effacer aussi l'historique des rappels envoyés
     * @return boolean     TRUE en cas de succès
     */
    public function delete($id)
    {
        $db = DB::getInstance();

        $db->begin();

        $db->delete('rappels_sms', 'id = ?', (int) $id);

        $db->commit();

        return true;
    }

    /**
     * Renvoie les données sur un rappel
     * @param  integer $id Numéro du rappel
     * @return array     Données du rappel
     */
    public function get($id)
    {
        return DB::getInstance()->first('SELECT * FROM rappels_sms WHERE id = ?;', (int)$id);
    }

    /**
     * Renvoie le nombre de rappels automatiques enregistrés
     * @return integer Nombre de rappels
     */
    public function countAll()
    {
        return DB::getInstance()->firstColumn('SELECT COUNT(*) FROM rappels_sms;');
    }

    /**
     * Liste des rappels triés par cotisation
     * @return array Liste des rappels
     */
    public function listByCotisation()
    {
        return DB::getInstance()->get('SELECT r.*,
			c.intitule, c.montant, c.duree, c.debut, c.fin
			FROM rappels_sms AS r
			INNER JOIN cotisations AS c ON c.id = r.id_cotisation
			ORDER BY r.id_cotisation, r.delai;');
    }

    /*
     * Envoi d'sms
     * Récupération des comptes
     * Récupération des expéditeurs
     * Mise en forme numéro téléphone (0, +xx, ., espace, etc)
     */

    public function sendRappels()
    {
        $db = DB::getInstance();
        $config = Config::getInstance();

        $query = '
        SELECT 
			*,
			/* Nombre de jours avant ou après expiration */
			(julianday(date()) - julianday(expiration)) AS nb_jours,
			/* Date de mise en œuvre du rappel */
			date(expiration, delai || \' days\') AS date_rappel
		FROM (
			SELECT m.*, r.delai, r.sujet, r.texte, r.id_cotisation, r.id AS id_rappel,
				m.'.$config->get('champ_identite').' AS identite,
				CASE WHEN c.duree IS NOT NULL THEN date(cm.date, \'+\'||c.duree||\' days\')
				WHEN c.fin IS NOT NULL THEN c.fin ELSE 0 END AS expiration
			FROM rappels_sms AS r
				INNER JOIN cotisations AS c ON c.id = r.id_cotisation
				INNER JOIN cotisations_membres AS cm ON cm.id_cotisation = c.id
				INNER JOIN membres AS m ON m.id = cm.id_membre
			WHERE
				/* Inutile de sélectionner les membres sans email */
				(m.email IS NULL OR m.email = \'\')
				/* Les cotisations ponctuelles ne comptent pas */
				AND (c.fin IS NOT NULL OR c.duree IS NOT NULL)
				/* Rien nest envoyé aux membres des catégories cachées, logique */
				AND m.id_categorie NOT IN (SELECT id FROM membres_categories WHERE cacher = 1)
    		/* Grouper par membre, pour n\'envoyer qu\'un seul rappel par membre/cotise */
	    	GROUP BY m.id, r.id_cotisation
			ORDER BY r.delai ASC
		)
		WHERE nb_jours >= delai 
			/* Pour ne pas spammer on n\'envoie pas de rappel antérieur au dernier rappel déjà effectué */
			AND id NOT IN (SELECT id_membre FROM rappels_envoyes AS re 
				WHERE id_cotisation = re.id_cotisation 
				AND re.date >= date(expiration, delai || \' days\')
			)
		ORDER BY nb_jours DESC;';

        $db->begin();

        foreach ($db->iterate($query) as $row)
        {
            sendAuto($row);
        }

        $db->commit();
        return true;
    }

    /**
     * Enregistrer un rappel
     * @param array $data Données du rappel
     * @return integer Numéro ID du rappel créé
     */
    public function addRappel($data)
    {
        $db = DB::getInstance();

        $this->_checkFields($data);

        $db->insert('rappels_envoyes', $data);

        return $db->lastInsertRowId();
    }

    public function replaceTagsInContent($content, $data = null)
    {
        $config = Config::getInstance();
        $tags = [
            '#NOM_ASSO'		=>	$config->get('nom_asso'),
            '#ADRESSE_ASSO'	=>	$config->get('adresse_asso'),
            '#EMAIL_ASSO'	=>	$config->get('email_asso'),
            '#SITE_ASSO'	=>	$config->get('site_asso'),
            '#URL_RACINE'	=>	WWW_URL,
            '#URL_SITE'		=>	WWW_URL,
            '#URL_ADMIN'	=>	ADMIN_URL,
        ];

        if (!empty($data) && is_array($data))
        {
            foreach ($data as $key=>$value)
            {
                $key = '#' . strtoupper($key);
                $tags[$key] = $value;
            }
        }

        return strtr($content, $tags);
    }

    /**
     * Envoi de SMS pour rappel automatisé
     * @param  array $data Données du rappel automatisé
     * @return boolean     TRUE
     */
    public function sendAuto($data)
    {
        $replace = (array) $data;
        $replace['date_rappel'] = Utils::sqliteDateToFrench($replace['date_rappel']);
        $replace['date_expiration'] = Utils::sqliteDateToFrench($replace['expiration']);
        $replace['nb_jours'] = abs($replace['nb_jours']);
        $replace['delai'] = abs($replace['delai']);

        $text = $this->replaceTagsInContent($data->texte, $replace);

        // Envoi du mail
        //Utils::sendEmail(Utils::EMAIL_CONTEXT_PRIVATE, $data->email, $subject, $text, $data->id);

        sendSMS($data->telephone, $text, $data->id);


        // Enregistrement en DB
        $this->addRappel([
            'id_cotisation' => $data->id_cotisation,
            'id_membre'     => $data->id,
            'media'         => Rappels_Envoyes::MEDIA_EMAIL,
            // On enregistre la date de mise en œuvre du rappel
            // et non pas la date d'envoi effective du rappel
            // car l'envoi du rappel peut ne pas être effectué
            // le jour où il aurait dû être envoyé (la magie des cron)
            'date'          => $data->date_rappel,
        ]);

        Plugin::fireSignal('rappels.auto', $data);

        return true;
    }

    public function sendSMS($telephone, $text, $id_membre = null)
    {
        // https://eu.api.ovh.com/createToken/index.cgi?GET=/sms&GET=/sms/*&PUT=/sms/*&DELETE=/sms/*&POST=/sms/*
        $smsClient = new SmsApi('', '', 'ovh-eu', '');
        $accounts = $smsClient->getAccounts();
        //$senders = $smsClient->getSenders();

        //if((count($comptes)>0)&&(count($senders)>0))
        // {
        $smsClient->setAccount($accounts[0]);
        //$smsClient->setSender($senders[0]);

        $sms = $smsClient->createMessage(false);
        $sms->addReceiver($telephone);
        $sms->setIsMarketing(false);
        $sms->setDeliveryDate(new \DateTime('now'));
        $sms->send($text);
        //} else {
        //    die('Impossible d\'envoyer un sms');
        //}
    }

}
<?php
namespace Garradin\Plugin\Cotisation;

use Garradin;
use Garradin\DB;
use Garradin\UserException;
use Garradin\Utils;

class Cotisations
{

    /**
	 * Vérification des champs fournis pour la modification de donnée
	 * @param  array $data Tableau contenant les champs à ajouter/modifier
	 * @return void
	 */
	protected function _checkFields(&$data, $compta = false)
	{
		$db = DB::getInstance();

        if (empty($data['date']) || !Utils::checkDate($data['date']))
        {
            throw new UserException('Date vide ou invalide.');
        }

		if (empty($data['id_cotisation']) 
			|| !$db->simpleQuerySingle('SELECT 1 FROM cotisations WHERE id = ?;', false, (int) $data['id_cotisation']))
		{
			throw new UserException('Cotisation inconnue.');
		}

		$data['id_cotisation'] = (int) $data['id_cotisation'];

		if (empty($data['id_membre']) 
			|| !$db->simpleQuerySingle('SELECT 1 FROM membres WHERE id = ?;', false, (int) $data['id_membre']))
		{
			throw new UserException('Membre inconnu ou invalide.');
		}

		$data['id_membre'] = (int) $data['id_membre'];

		if ($compta)
		{
	        if (!isset($data['moyen_paiement']) || trim($data['moyen_paiement']) === '')
	        {
	        	throw new UserException('Moyen de paiement inconnu ou invalide.');
	        }

			if ($data['moyen_paiement'] != 'ES')
	        {
	            if (trim($data['banque']) == '')
	            {
	                throw new UserException('Le prestataire choisi est invalide.');
	            }

	            if (!$db->simpleQuerySingle('SELECT 1 FROM compta_comptes WHERE id = ?;',
	            	false, $data['banque']))
	            {
	                throw new UserException('Le prestataire choisi n\'existe pas.');
	            }
	        }

	        if (!isset($data['montant']) || !is_numeric($data['montant']) || $data['montant'] < 0)
	        {
	        	throw new UserException('Le montant indiqué n\'est pas un nombre valide : doit être supérieur ou égal à zéro.');
	        }
	    }
	}

	/**
	 * Enregistrer un événement de cotisation
	 * @param array $data Tableau des champs à insérer
	 * @return integer ID de l'événement créé
	 */
	public function add($data)
	{
		$db = DB::getInstance();

		$co = $db->simpleQuerySingle('SELECT * FROM cotisations WHERE id = ?;', 
			true, (int)$data['id_cotisation']);

		$this->_checkFields($data, !empty($co['id_categorie_compta']));

		$check = $db->simpleQuerySingle('SELECT 1 FROM cotisations_membres 
			WHERE id_cotisation = ? AND id_membre = ? AND date = ?;', 
			false, (int)$data['id_cotisation'], (int)$data['id_membre'], $data['date']);

		if ($check)
		{
			throw new UserException('Cette cotisation a déjà été enregistrée pour ce jour-ci et ce membre-ci.');
		}

		$db->begin();

		$db->simpleInsert('cotisations_membres', [
			'date'				=>	$data['date'],
			'id_cotisation'		=>	$data['id_cotisation'],
			'id_membre'			=>	$data['id_membre'],
			]);

		$id = $db->lastInsertRowId();

		if ($co['id_categorie_compta'] && $data['montant'] > 0)
		{
			try {
		        $id_operation = $this->addOperationCompta($id, [
		        	'id_categorie'	=>	$co['id_categorie_compta'],
		            'libelle'       =>  'Cotisation (automatique)',
		            'montant'       =>  $data['montant'],
		            'date'          =>  $data['date'],
		            'moyen_paiement'=>  $data['moyen_paiement'],
		            'numero_cheque' =>  isset($data['numero_cheque']) ? $data['numero_cheque'] : null,
		            'id_auteur'     =>  $data['id_auteur'],
		            'banque'		=>	isset($data['banque']) ? $data['banque'] : null,
		            'id_membre'		=>	$data['id_membre'],
		        ]);
	        }
	        catch (\Exception $e)
	        {
	        	$db->rollback();
	        	throw $e;
	        }
		}

		$db->commit();

		return $id;
	}

	/**
	 * Ajouter une écriture comptable pour un paiemement membre
	 * @param int $id Numéro de la cotisation membre
	 * @param array $data Données
	 */
	public function addOperationCompta($id, $data)
	{
		$journal = new \Garradin\Compta\Journal;
		$db = DB::getInstance();

		if (!isset($data['libelle']) || trim($data['libelle']) == '')
		{
			throw new UserException('Le libellé ne peut rester vide.');
		}

		$data['libelle'] = trim($data['libelle']);

		if (!isset($data['montant']) || !is_numeric($data['montant']) || (float)$data['montant'] < 0)
		{
			throw new UserException('Le montant doit être un nombre positif et valide.');
		}

		$data['montant'] = (float) $data['montant'];

		if ($data['moyen_paiement'] == 'ES')
		{
			$debit = \Garradin\Compta\Comptes::CAISSE;
        }
        elseif($data['moyen_paiement'] == 'CH')
        {
        	$debit = "5112";
        }
        else
        {
        	$debit = $data['banque'];
        }

        $credit = $db->simpleQuerySingle('SELECT compte FROM compta_categories WHERE id = ?;', 
        	false, $data['id_categorie']);

        $id_operation = $journal->add([
            'libelle'       =>  $data['libelle'],
            'montant'       =>  $data['montant'],
            'date'          =>  $data['date'],
            'moyen_paiement'=>  $data['moyen_paiement'],
            'numero_cheque' =>  isset($data['numero_cheque']) ? $data['numero_cheque'] : null,
            'compte_debit'  =>  $debit,
            'compte_credit' =>  $credit,
            'id_categorie'  =>  (int)$data['id_categorie'],
            'id_auteur'     =>  (int)$data['id_auteur'],
        ]);

        $db->simpleInsert('membres_operations', [
        	'id_operation' => $id_operation,
        	'id_membre' => $data['id_membre'],
        	'id_cotisation' => (int)$id,
        ]);

        return $id_operation;
	}
}
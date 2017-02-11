<?php

namespace Garradin;

$error = false;
$gendon = new Plugin\RecuDon\GenDon;

if ($user['droits']['config'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

if (!empty($_POST['save'])) {
    if (!Utils::CSRF_check('new_recu')) {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    } else {
        try {
            $id_add = $gendon->add([
                'nom' => Utils::post('nom'),
                'prenom' => Utils::post('prenom'),
                'adresse' => Utils::post('adresse'),
                'codepostal' => Utils::post('codepostal'),
                'ville' => Utils::post('ville'),
                'date' => Utils::post('date'),
                'montant' => Utils::post('montant'),
                'mode_paiement' => Utils::post('paiement'),
                'gen_date' => Utils::post('codepostal'),
                'gen_signature' => Utils::post('nom'),
                'gen_ordre' => Utils::post('numero'),
            ]);

            Utils::redirect(PLUGIN_URL . 'index.php?ok='.$id_add.'&ordre='.Utils::post('numero'));
        } catch (UserException $e) {
            $error = $e->getMessage();
        }
    }
}



$trecus = $gendon->listSimple();

$tpl->assign('date', $membres->sessionGet('compta_date') ?: false);
$tpl->assign('trecus', $trecus);
$tpl->assign('error', $error);
$tpl->assign('ok', (int) Utils::get('ok'));
$tpl->assign('ordre', (string) Utils::get('ordre'));
$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

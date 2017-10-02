<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$benevolat = new BD();

$error = false;

if (!empty($_POST['add']))
{
    if (!Utils::CSRF_check('add_categorie'))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $data = [
                'nom'               =>  Utils::post('nom'),
                'taux_horaire'              =>  Utils::post('taux'),
                'description'       =>  Utils::post('description'),
            ];

            $benevolat->addCategorie($data);
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);
$tpl->assign('liste', $benevolat->getListeCategories());
$tpl->display(PLUGIN_ROOT . '/templates/categorie.tpl');

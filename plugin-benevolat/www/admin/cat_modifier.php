<?php

namespace Garradin;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$benevolat = new Plugin\Benevolat\BD();

$categorie = $benevolat->getCategorie((int) Utils::get('id'));

$error = false;

if (!empty($_POST['add']))
{
    if (!Utils::CSRF_check('edit_categorie'))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $data = [
                'nom'               =>  Utils::post('nom'),
                'taux_horaire'              =>  Utils::post('taux_horaire'),
                'description'       =>  Utils::post('description'),
            ];

            $benevolat->editCategorie($categorie['id'], $data);
            utils::redirect(PLUGIN_URL . 'categorie.php?edit_cat_ok');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);
$tpl->assign('categorie', $categorie);
$tpl->display(PLUGIN_ROOT . '/templates/cat_modifier.tpl');

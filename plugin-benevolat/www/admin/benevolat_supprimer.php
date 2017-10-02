<?php

namespace Garradin;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$benevolat = new Plugin\Benevolat\BD();

$contribution = $benevolat->getEnregistrement((int)Utils::get('id'));

if(empty($contribution))
{
    throw new UserException('Contribution inexistante.');
}

$error = false;

if (!empty($_POST['delete']))
{
    if (!Utils::CSRF_check('ben_supprimer_'.$contribution['id']))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try
        {
            $benevolat->removeBenevolat($contribution['id']);
            utils::redirect(PLUGIN_URL . 'index.php?suppr_contrib_ok');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);
$tpl->assign('contribution', $contribution);
$tpl->display(PLUGIN_ROOT . '/templates/benevolat_supprimer.tpl');

<?php
namespace Garradin;

if ($user['droits']['compta'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$gendon = new Plugin\RecuDon\GenDon;

$recu = $gendon->get(Utils::get('id'));

if (!$recu)
{
    throw new UserException("Le reçu demandé n'existe pas.");
}

$error = false;

if (!empty($_POST['remove']))
{
    if (!Utils::CSRF_check('recu_supprimer_'.$recu['id']))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try
        {
            $gendon->remove($recu['id']);
            Utils::redirect(PLUGIN_URL . 'recu.php');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);

$tpl->assign('recu', $recu);

$tpl->display(PLUGIN_ROOT . '/templates/supprimer.tpl');
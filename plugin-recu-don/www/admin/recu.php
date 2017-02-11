<?php
namespace Garradin;

if ($user['droits']['compta'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$error = false;

if (isset($_GET['ok']))
{
    $error = 'OK';
}

$recus = new Plugin\RecuDon\GenDon;

$trecus = $recus->listSimple();

$tpl->assign('trecus', $trecus);
$tpl->assign('error', $error);
$tpl->display(PLUGIN_ROOT . '/templates/recu.tpl');

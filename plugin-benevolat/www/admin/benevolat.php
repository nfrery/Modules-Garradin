<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$benevolat = new BD();

$enregistrement = $benevolat->getEnregistrements();

$error = false;

if($enregistrement == NULL)
{
    $error = 'Aucun enregistrement.';
}

$tpl->assign('error', $error);
$tpl->assign('liste', $enregistrement);
$tpl->display(PLUGIN_ROOT . '/templates/benevolat.tpl');

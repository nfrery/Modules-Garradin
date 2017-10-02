<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$benevolat = new BD();

$enregistrement = $benevolat->getEnregistrement((int)Utils::get('id'));

$error = false;

if($enregistrement == NULL)
{
    $error = 'Contribution bénévole inexistante.';
}

$tpl->assign('error', $error);
$tpl->assign('contribution', $enregistrement);
$tpl->display(PLUGIN_ROOT . '/templates/benevolat_voir.tpl');

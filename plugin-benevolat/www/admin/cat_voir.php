<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$benevolat = new BD();

$enregistrements = $benevolat->getEnregistrementsCategorie((int)Utils::get('id'));

$error = false;

if($enregistrements == NULL)
{
    $error = 'Catégorie inconnue ou sans enregistrement.';
}

$tpl->assign('error', $error);
$tpl->assign('liste', $enregistrements);
$tpl->display(PLUGIN_ROOT . '/templates/cat_voir.tpl');

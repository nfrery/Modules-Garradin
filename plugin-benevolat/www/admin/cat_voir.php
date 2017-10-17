<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

$session->requireAccess('config', Membres::DROIT_ECRITURE);

$benevolat = new BD();

$enregistrements = $benevolat->getEnregistrementsCategorie(qg('id'));

$error = false;

if($enregistrements == NULL)
{
    $error = 'Catégorie inconnue ou sans enregistrement.';
}

$tpl->assign('error', $error);
$tpl->assign('liste', $enregistrements);
$tpl->display(PLUGIN_ROOT . '/templates/cat_voir.tpl');

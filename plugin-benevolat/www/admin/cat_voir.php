<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

$session->requireAccess('config', Membres::DROIT_ECRITURE);

$benevolat = new BD();

$enregistrements = $benevolat->getEnregistrementsCategorie(qg('id'));

if($enregistrements == NULL)
{
    $form->addError('Catégorie inconnue ou sans enregistrement.');
}

$tpl->assign('categorie', $benevolat->getCategorie(qg('id')));
$tpl->assign('liste', $enregistrements);
$tpl->display(PLUGIN_ROOT . '/templates/cat_voir.tpl');

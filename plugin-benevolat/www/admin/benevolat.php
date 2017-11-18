<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

$benevolat = new BD();

$enregistrement = $benevolat->getEnregistrements();

if($enregistrement == NULL)
{
    $form->addError('Aucun enregistrement.');
}

$tpl->assign('liste', $enregistrement);
$tpl->display(PLUGIN_ROOT . '/templates/benevolat.tpl');

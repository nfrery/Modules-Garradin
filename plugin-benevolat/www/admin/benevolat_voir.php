<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

$session->requireAccess('config', Membres::DROIT_ECRITURE);

$benevolat = new BD();

$enregistrement = $benevolat->getEnregistrement(qg('id'));

if($enregistrement == NULL)
{
    $form->addError('Contribution bénévole inexistante.');
}


$tpl->assign('contribution', $enregistrement);
$tpl->display(PLUGIN_ROOT . '/templates/benevolat_voir.tpl');

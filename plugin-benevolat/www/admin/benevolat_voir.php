<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

$benevolat = new BD();

$enregistrement = $benevolat->getEnregistrement(qg('id'));
$confirmation = false;
if(empty($enregistrement))
{
    throw new UserException('Cette contribution n\'existe pas.');
}

if(qg('edit'))
{
    $confirmation = 'ok';
}

if($enregistrement == NULL)
{
    $form->addError('Contribution bénévole inexistante.');
}

$exercices = new Compta\Exercices;
$tpl->assign('exercice',$exercices->get($enregistrement->id_exercice));
$tpl->assign('edit', $confirmation);
$tpl->assign('contribution', $enregistrement);
$tpl->display(PLUGIN_ROOT . '/templates/benevolat_voir.tpl');

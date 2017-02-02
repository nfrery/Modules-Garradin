<?php

namespace Garradin;

use Plugin\recudon\GenCon;

if ($user['droits']['config'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

/**
*	Récupération des infos sur l'association
*/
//$GenDon = new Plugin\GenDon;
//$informations = $GenDon->getInfo();

//$pdf = GenCon::GenPDF();
//GenCon::Output($pdf);
$machine = "bidule";
$tpl->assign('machin', $machine);

$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

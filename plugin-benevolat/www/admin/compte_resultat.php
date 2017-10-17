<?php

namespace Garradin;

$bd= new Plugin\Benevolat\BD;
$rapports = new Compta\Rapports;

$cr = $rapports->compteResultat(['id_exercice' => qg('exercice')]);
$crb =  $bd->compteResultat(['id_exercice' => qg('exercice')]);

$crb['produits']['general'] = $cr['produits']['total'] + $crb['produits']['total'];
$crb['charges']['general'] = $cr['charges']['total'] + $crb['charges']['total'];

$tpl->assign('compte_resultat', $cr);
$tpl->assign('benevolat', $crb);
$tpl->display(PLUGIN_ROOT . '/templates/compte_resultat.tpl');

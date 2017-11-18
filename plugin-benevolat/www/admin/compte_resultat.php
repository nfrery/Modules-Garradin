<?php

namespace Garradin;

$bd= new Plugin\Benevolat\BD;
$rapports = new Compta\Rapports;

$liste_exercices = $bd->getListeExercices();
$current_exercice = (int)qg('exercice') ?: 0;
$current_projet = (int)qg('projet') ?: 0;

$compte_resultat = $rapports->compteResultat(['id_exercice' => qg('exercice')]);
$compte_benevolat =  $bd->compteResultatBenevolat(['id_exercice' => qg('exercice')]);

$compte_benevolat['produits']['general'] = $compte_benevolat['produits']['total'] + $compte_resultat['produits']['total'];
$compte_benevolat['charges']['general'] = $compte_benevolat['charges']['total'] + $compte_resultat['charges']['total'];

$tpl->assign('liste_exercices', $liste_exercices);
$tpl->assign('current_exercice', $current_exercice);
$tpl->assign('current_projet', $current_projet);
$tpl->assign('compte_resultat', $compte_resultat);
$tpl->assign('benevolat', $compte_benevolat);
$tpl->display(PLUGIN_ROOT . '/templates/compte_resultat.tpl');

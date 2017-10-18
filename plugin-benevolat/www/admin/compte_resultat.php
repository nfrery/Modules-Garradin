<?php

namespace Garradin;

$bd= new Plugin\Benevolat\BD;
$rapports = new Compta\Rapports;
$exercices = new Compta\Exercices;

$liste_exercices = $bd->getListeExercices();
$current_exercice = (int)qg('exercice') ?: 0;
$current_projet = (int)qg('projet') ?: 0;
$valorise = $bd->compteValorise();

$compte_resultat = $rapports->compteResultat(['id_exercice' => qg('exercice')]);
$compte_benevolat =  $bd->compteResultat(['id_exercice' => qg('exercice')]);

//$compte_benevolat['produits']['comptes']['864'] += $valorise;
//$compte_benevolat['charges']['comptes']['870'] += $valorise;

$compte_benevolat['produits']['general'] = $compte_resultat['produits']['total'] + $compte_benevolat['produits']['total'];
$compte_benevolat['charges']['general'] = $compte_resultat['charges']['total'] + $compte_benevolat['charges']['total'];

$tpl->assign('liste_exercices', $liste_exercices);
$tpl->assign('current_exercice', $current_exercice);
$tpl->assign('current_projet', $current_projet);
$tpl->assign('compte_resultat', $compte_resultat);
$tpl->assign('benevolat', $compte_benevolat);
$tpl->display(PLUGIN_ROOT . '/templates/compte_resultat.tpl');

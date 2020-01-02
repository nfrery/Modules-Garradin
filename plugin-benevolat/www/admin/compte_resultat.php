<?php

namespace Garradin;

$session->requireAccess('compta', Membres::DROIT_ACCES);

$bd= new Plugin\Benevolat\BD;
$rapports = new Compta\Rapports;

$liste_exercices = $bd->getListeExercices();
$liste_projets = $bd->getListeProjets();

if(qg('projet'))
{
    $projets = new Compta\Projets;
    $projet = $projets->get((int) qg('projet'));

    if (!$projet)
    {
        throw new UserException('Projet inconnu.');
    }

    $criterias['id_projet'] = $projet->id;
    $compte_resultat = $rapports->compteResultat($criterias, [86, 87]);
    $compte_benevolat =  $bd->compteResultatBenevolat($criterias);
    $compte_benevolat['produits']['general'] = $compte_benevolat['produits']['total'] + $compte_resultat['produits']['total'];
    $compte_benevolat['charges']['general'] = $compte_benevolat['charges']['total'] + $compte_resultat['charges']['total'];
    $tpl->assign('compte_resultat', $compte_resultat);
    $tpl->assign('benevolat', $compte_benevolat);
    $tpl->assign('projet', $projet);
}
elseif (qg('exercice'))
{
    $exercices = new Compta\Exercices;
    $exercice = $exercices->get((int)qg('exercice'));

    if (!$exercice)
    {
        throw new UserException('Exercice inconnu.');
    }

    $criterias['id_exercice'] = $exercice->id;
    $compte_resultat = $rapports->compteResultat($criterias, [86, 87]);
    $compte_benevolat =  $bd->compteResultatBenevolat($criterias);
    $compte_benevolat['produits']['general'] = $compte_benevolat['produits']['total'] + $compte_resultat['produits']['total'];
    $compte_benevolat['charges']['general'] = $compte_benevolat['charges']['total'] + $compte_resultat['charges']['total'];
    $tpl->assign('compte_resultat', $compte_resultat);
    $tpl->assign('benevolat', $compte_benevolat);
    $tpl->assign('cloture', $exercice->cloture ? $exercice->fin : time());
    $tpl->assign('exercice', $exercice);
}

$tpl->assign('liste_exercices', $liste_exercices);
$tpl->assign('liste_projets', $liste_projets);
$tpl->display(PLUGIN_ROOT . '/templates/compte_resultat.tpl');

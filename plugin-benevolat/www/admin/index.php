<?php

namespace Garradin;

use Garradin\Compta\Exercices;
use Garradin\Compta\Journal;

if ($q = qg('q'))
{
    $aResult = [];
    if (!empty($q))
    {
        $membres       = new Membres;
        $membres_liste = $membres->search('nom', $q);

        $i = 0;
        foreach ($membres_liste as $membre) {
            $a = (array)$membre;
            $aResult[$i]['id']    =  $a['id'];
            $aResult[$i]['value'] =  $a['nom'];
            if (!empty($a['email'])) {
                $aResult[$i]['value'] .= ' (' . $a['email'] . ')';
            }
            $i++;
        }
    }
    echo json_encode($aResult);
    exit;
}

$benevolat = new Plugin\Benevolat\BD;
$journal = new Journal;

$ok = false;

if (f('add') && $form->check('add_benevolat'))
{
    try {
        $data_benevolat = [
            'nb_heures'         =>  f('nb_heures'),
            'id_categorie'      =>  f('id_categorie'),
            'id_benevole'       =>  f('id_benevole'),
            'nom_benevole'      =>  f('nom_benevole'),
            'description'       =>  f('description'),
            'date'              =>  f('date'),
            'plage'             =>  f('plage'),
            'date_fin'          =>  f('date_fin'),
        ];
        $data_journal = [
            'date'              =>  f('date'),
            'id_auteur'         =>  $session->getUser()->id,
            'id_projet'         =>  f('projet'),
        ];

        $id = $benevolat->addBenevolat($data_benevolat, $data_journal);
        utils::redirect(PLUGIN_URL . 'index.php?add_ben_ok='.(int)$id);
    }
    catch (UserException $e)
    {
        $form->addError($e->getMessage());
    }
}

if(qg('suppr_contrib_ok'))
{
    $ok = "Contribution supprimée.";
}

if(qg('suppr_cat_ok'))
{
    $ok = "Catégorie supprimée.";
}

if(qg('add_ben_ok'))
{
    $ok = "Contribution ajoutée avec succès.";
}

$tpl->assign('ok', $ok);
$tpl->assign('liste_cat', $benevolat->getListeCategories());
$tpl->assign('projets', (new Compta\Projets)->getAssocList());
$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

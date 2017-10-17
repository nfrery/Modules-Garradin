<?php

namespace Garradin;

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

$benevolat = new Plugin\Benevolat\BD();

$ok = false;

if (f('add') && $form->check('add_benevolat'))
{
    try {
        $data = [
            'nom_prenom'        =>  f('nom_prenom'),
            'id_membre'         =>  f('id_membre'),
            'date'              =>  f('date'),
            'date_fin'          =>  f('date_fin'),
            'plage'             =>  f('plage'),
            'heures'            =>  f('heure'),
            'id_categorie'      =>  f('id_categorie'),
            'description'       =>  f('description'),
            'id_membre_ajout'   =>  $session->getUser()->id,
        ];

        $benevolat->addBenevolat($data);
        utils::redirect(PLUGIN_URL . 'index.php?add_ben_ok');
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
$tpl->assign('liste_ben', $benevolat->getLastsEnregistrements());
$tpl->assign('liste_cat', $benevolat->getListeCategories());
$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

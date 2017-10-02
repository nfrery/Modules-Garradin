<?php

namespace Garradin;

use Garradin\Plugin\Benevolat\BD;

if (isset($_GET['q'])) {

    $aResult = [];
    if (!empty($_GET['q'])) {
        $membres       = new Membres;
        $membres_liste = $membres->search('nom', $_GET['q']);

        $i = 0;
        foreach ($membres_liste as $membre) {
            $aResult[$i]['id']    = $membre['id'];
            $aResult[$i]['value'] = $membre['nom'];
            if (!empty($membre['email'])) {
                $aResult[$i]['value'] .= ' (' . $membre['email'] . ')';
            }
            $i++;
        }
    }
    echo json_encode($aResult);
    exit;
}

$benevolat = new Plugin\Benevolat\BD();

$error = false;

if (!empty($_POST['add']))
{
    if (!Utils::CSRF_check('add_benevolat'))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $data = [
                'nom_prenom'              =>  Utils::post('nom_prenom'),
                'id_membre'     =>  Utils::post('id_membre'),
                'date'         =>  Utils::post('date'),
                'heures'           =>  Utils::post('heure'),
                'id_categorie'    =>  Utils::post('id_categorie'),
                'description'     =>  Utils::post('description'),
                'id_membre_ajout'     =>  '1',
            ];

            $benevolat->addBenevolat($data);
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);
$tpl->assign('liste_ben', $benevolat->getLastsEnregistrements());
$tpl->assign('liste_cat', $benevolat->getListeCategories());
$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

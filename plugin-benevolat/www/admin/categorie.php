<?php

namespace Garradin;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$benevolat = new Plugin\Benevolat\BD();

$error = false;
$ok = false;

if (!empty($_POST['add']))
{
    if (!Utils::CSRF_check('add_categorie'))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $data = [
                'nom'               =>  Utils::post('nom'),
                'taux_horaire'              =>  Utils::post('taux'),
                'description'       =>  Utils::post('description'),
            ];

            $benevolat->addCategorie($data);
            utils::redirect(PLUGIN_URL . 'categorie.php?add_cat_ok');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

if(isset($_GET['edit_cat_ok']))
{
    $ok = "Catégorie éditée avec succès.";
}
if(isset($_GET['add_cat_ok']))
{
    $ok = "Catégorie ajoutée avec succès.";
}


$tpl->assign('error', $error);
$tpl->assign('ok', $ok);
$tpl->assign('liste', $benevolat->getListeCategories());
$tpl->display(PLUGIN_ROOT . '/templates/categorie.tpl');

<?php

namespace Garradin;

$session->requireAccess('config', Membres::DROIT_ECRITURE);

$benevolat = new Plugin\Benevolat\BD();

$ok = false;

$confirmation = false;

if(qg('edit'))
{
    $confirmation = 'ok';
}


if(f('add') && $form->check('add_categorie'))
{
    try {
        $data = [
            'nom'               =>  f('nom'),
            'taux_horaire'      =>  f('taux'),
            'description'       =>  f('description'),
        ];
        $benevolat->addCategorie($data);
        utils::redirect(PLUGIN_URL . 'categorie.php?add_cat_ok');
    }
    catch (UserException $e)
    {
        $form->addError($e->getMessage());
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

$tpl->assign('edit', $confirmation);
$tpl->assign('ok', $ok);
$tpl->assign('liste', $benevolat->getListeCategories());
$tpl->display(PLUGIN_ROOT . '/templates/categorie.tpl');

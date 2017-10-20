<?php

namespace Garradin;

$session->requireAccess('config', Membres::DROIT_ECRITURE);

$benevolat = new Plugin\Benevolat\BD();

$categorie = $benevolat->getCategorie(qg('id'));


if(f('add') && $form->check('edit_categorie'))
{
    $data = [
    'nom'               =>  f('nom'),
    'taux_horaire'      =>  f('taux_horaire'),
    'description'       =>  f('description'),
    ];
    try {
        $benevolat->editCategorie($categorie->id, $data);
        utils::redirect(PLUGIN_URL . 'categorie.php?edit=ok');
    }
    catch (UserException $e)
    {
        $form->addError($e->getMessage());
    }

}

$tpl->assign('categorie', $categorie);
$tpl->display(PLUGIN_ROOT . '/templates/cat_modifier.tpl');

<?php

namespace Garradin;

$session->requireAccess('config', Membres::DROIT_ECRITURE);

$benevolat = new Plugin\Benevolat\BD();

$categorie = $benevolat->getCategorie(qg('id'));

$db = DB::getInstance();

if(empty($categorie))
{
    throw new UserException('Categorie inexistante.');
}

if(f('delete') && $form->check('cat_supprimer_'.$categorie->id))
{
    try
    {
        $benevolat->removeCategorie($categorie->id);
        utils::redirect(PLUGIN_URL . 'categorie.php?suppr_cat_ok');
    }
    catch (UserException $e)
    {
        $form->addError($e->getMessage());
    }
}

$tpl->assign('categorie', $categorie);
$tpl->display(PLUGIN_ROOT . '/templates/cat_supprimer.tpl');

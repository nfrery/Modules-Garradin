<?php

namespace Garradin;

$session->requireAccess('config', Membres::DROIT_ECRITURE);

$benevolat = new Plugin\Benevolat\BD();

$contribution = $benevolat->getEnregistrement(qg('id'));

if(empty($contribution))
{
    throw new UserException('Contribution inexistante.');
}

if (f('delete') && $form->check('ben_supprimer_'.$contribution['id']))
{
        try
        {
            $benevolat->removeBenevolat($contribution['id']);
            utils::redirect(PLUGIN_URL . 'index.php?suppr_contrib_ok');
        }
        catch (UserException $e)
        {
            $form->addError($e->getMessage());
        }
}

$tpl->assign('contribution', $contribution);
$tpl->display(PLUGIN_ROOT . '/templates/benevolat_supprimer.tpl');

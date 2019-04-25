<?php
namespace Garradin;

use Garradin\Plugin\SMS\SMS;
$session->requireAccess('membres', Membres::DROIT_ADMIN);

if (!qg('id') || !is_numeric(qg('id')))
{
    throw new UserException("Argument du numéro de rappel manquant.");
}

$rappels = new SMS;

$rappel = $rappels->get(qg('id'));

if (!$rappel)
{
    throw new UserException("Ce rappel n'existe pas.");
}

if (f('delete') && $form->check('delete_rappel_' . $rappel->id))
{
    try {
        $rappels->delete($rappel->id);
        utils::redirect(PLUGIN_URL . 'rappels.php');
    }
    catch (UserException $e)
    {
        $form->addError($e->getMessage());
    }
}

$tpl->assign('rappel', $rappel);

$tpl->display(PLUGIN_ROOT . '/templates/rappel_supprimer.tpl');

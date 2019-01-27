<?php

namespace Garradin;

$session->requireAccess('config', Membres::DROIT_ADMIN);


if(f('config') && $form->check('modif_config'))
{
    try{
        $plugin->setConfig('soutien', (bool) f('soutien'));
        utils::redirect(utils::plugin_url());
    }
    catch (UserException $e)
    {
        $from->addError($e->getMessage());
    }
}

$tpl->display(PLUGIN_ROOT . '/templates/config.tpl');

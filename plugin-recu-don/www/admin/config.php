<?php

namespace Garradin;

if ($user['droits']['config'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$error = false;

if (utils::post('save'))
{
    if (!utils::CSRF_check('config_plugin_' . $plugin->id()))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $plugin->setConfig('display_hello', (bool)utils::post('display_hello'));
            utils::redirect(utils::plugin_url());
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);

$tpl->display(PLUGIN_ROOT . '/templates/config.tpl');

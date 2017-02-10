<?php

namespace Garradin;

if ($user['droits']['config'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$error = false;

if (isset($_GET['ok']))
{
    $error = 'OK';
}

if (utils::post('save'))
{
    if (!utils::CSRF_check('config_plugin_' . $plugin->id()))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $plugin->setConfig('droit_art200', (bool)utils::post('droit_art200'));
            $plugin->setConfig('droit_art238bis', (bool)utils::post('droit_art238bis'));
            $plugin->setConfig('droit_art885-0VbisA', (bool)utils::post('droit_art885-0VbisA'));
            $plugin->setConfig('numero_rue', (string)utils::post('numero_rue'));
            $plugin->setConfig('rue', (string)utils::post('rue'));
            $plugin->setConfig('codepostal', (string)utils::post('codepostal'));
            $plugin->setConfig('ville', (string)utils::post('ville'));
            $plugin->setConfig('objet0', (string)utils::post('objet0'));
            $plugin->setConfig('objet1', (string)utils::post('objet1'));
            $plugin->setConfig('objet2', (string)utils::post('objet2'));
            utils::redirect(PLUGIN_URL . 'config.php?ok');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);

$tpl->display(PLUGIN_ROOT . '/templates/config.tpl');

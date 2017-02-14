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
            $plugin->setConfig('bdd_login', (string)utils::post('bdd_login'));
            $plugin->setConfig('bdd_passwd', (string)utils::post('bdd_passwd'));
            $plugin->setConfig('bdd_name', (string)utils::post('bdd_name'));
            $plugin->setConfig('bdd_table', (string)utils::post('bdd_table'));
            $plugin->setConfig('bdd_group', (string)utils::post('bdd_group'));
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

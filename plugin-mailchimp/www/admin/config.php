<?php

namespace Garradin;

if ($user['droits']['config'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$error = false;

// Restauration de ce qui était en session
if ($champs = $membres->sessionGet('champs_membres'))
{
    $champs = new Membres\Champs($champs);
}
else
{
    // Il est nécessaire de créer une nouvelle instance ici, sinon
    // l'enregistrement des modifs ne marchera pas car les deux instances seront identiques.
    // Càd si on utilise directement l'instance de $config, elle sera modifiée directement
    // du coup quand on essaiera de comparer si ça a changé ça comparera deux fois la même chose
    // donc ça n'aura pas changé forcément.
    $champs = new Membres\Champs($config->get('champs_membres'));
}

$gestion = new Plugin\MailChimp\Gestion;

if($plugin->getConfig('key_api') != "")
{
    $listes = $gestion->getLists();
    $listes = $listes['lists'];
} else {
    $listes = false;
}

if (isset($_GET['ok']))
{
    $error = 'OK';
}

if($listes == false)
{
    $listes = "";
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
            $plugin->setConfig('id_list', (string)utils::post('id_list'));
            $plugin->setConfig('key_api', (string)utils::post('key_api'));
            $plugin->setConfig('id_formulaire', (string)utils::post('id_formulaire'));
            utils::redirect(PLUGIN_URL . 'config.php?ok');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);
$tpl->assign('formulaires', $champs->getAll());
$tpl->assign('listes', $listes);

$tpl->display(PLUGIN_ROOT . '/templates/config.tpl');

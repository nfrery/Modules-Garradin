<?php
namespace Garradin;

$gestion = new Plugin\MailChimp\Gestion;

if ($user['droits']['compta'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}


$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

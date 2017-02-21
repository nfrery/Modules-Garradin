<?php
namespace Garradin;

$error = false;
$gendon = new Plugin\Vote\SQL;

if ($user['droits']['compta'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$tpl->assign('error', $error);
$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

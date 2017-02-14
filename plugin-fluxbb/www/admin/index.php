<?php
namespace Garradin;

if ($user['droits']['config'] < Membres::DROIT_ADMIN)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$sql = new Plugin\FluxBB\SQL;

$tpl->assign('te',$sql->recherche_adherent(3));
$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

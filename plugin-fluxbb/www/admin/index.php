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

$sql = new Plugin\FluxBB\SQL;

$tpl->assign('liste_adherents_non_lie',$sql->listeAdherentsSansCompteFluxBB());
$tpl->assign('te',$sql->recherche_adherent(3));
$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

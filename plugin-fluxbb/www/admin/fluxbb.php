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

function public connexion()
{
    if($bdd = mysqli_connect($plugin->getConfig('bdd_host'), $plugin->getConfig('bdd_login'), $plugin->getConfig('bdd_passwd'), $plugin->getConfig('bdd_name')))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function public ajout_colonnes($bdd)
{
    $resultat = mysqli_query($bdd, "ALTER TABLE ".$plugin->getConfig('bdd_table')."users ADD garradin_id INT(10) NULL UNIQUE;");
}

function public suppression_colonnes($bdd)
{

}

function public adhesionStart($bdd, $id_fluxbb)
{

}

function public adhesionStop($bdd, $id_fluxbb)
{

}

function public recherche_adherent($bdd, $mail)
{
    // Recheche si un utilisateur de fluxbb possède le mail d'un adhérent
    $resultat = mysqli_query($bdd, "SELECT id FROM ".$plugin->getConfig('bdd_table')."users WHERE email=".$mail.";");
    // Si c'est le cas j'ajoute le son id dans la table plugin_fluxbb

    // Dans le cas contraire je ne fais rien

}

/*
*   "ALTER TABLE ".$plugin->getConfig('bdd_table')."users ADD garradin_id INT(10) NULL UNIQUE;"
*   "ALTER TABLE ".$plugin->getConfig('bdd_table')."date ADD garradin_id INT(10) NULL UNIQUE;"
*   "ALTER TABLE ".$plugin->getConfig('bdd_table')."duree ADD garradin_id INT(10) NULL UNIQUE;"
*   "ALTER TABLE ".$plugin->getConfig('bdd_table')."date ADD garradin_id INT(10) NULL UNIQUE;"
*
*/

$tpl->assign('error', $error);
$tpl->display(PLUGIN_ROOT . '/templates/fluxbb.tpl');
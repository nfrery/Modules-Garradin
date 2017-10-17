<?php

namespace Garradin;

use Garradin\Plugin\Bicycode\Registre;

$session->requireAccess('config', Membres::DROIT_ADMIN);
/*
if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}
*/
$registre = new Registre();

if(f('add') && $form->check('add_marquage'))
{
    $data = [
    'nom'              =>  f('nom'),
    'prenom'     => f('prenom'),
    'adresse'         =>  f('adresse'),
    'code_postal'           =>  f('code_postal'),
    'ville'    =>  f('ville'),
    'numero_piece_identite'     =>  f('numero_piece_identite'),
    'date_marquage'            =>  f('date_marquage'),
    'telephone'            =>  f('telephone'),
    'numero_bicycode'            =>  f('numero_bicycode'),
    ]  ;

    try {
            $registre->addBicycode($data);
        }
        catch (UserException $e)
        {
            $form->addError ($e->getMessage());
        }
}

$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

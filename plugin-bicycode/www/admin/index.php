<?php

namespace Garradin;

use Garradin\Plugin\Bicycode\Registre;

if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
{
    throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
}

$registre = new Registre();

$error = false;

if (!empty($_POST['add']))
{
    if (!Utils::CSRF_check('add_marquage'))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $data = [
                'nom'              =>  Utils::post('nom'),
                'prenom'     =>  Utils::post('prenom'),
                'adresse'         =>  Utils::post('adresse'),
                'code_postal'           =>  Utils::post('code_postal'),
                'ville'    =>  Utils::post('ville'),
                'numero_piece_identite'     =>  Utils::post('numero_piece_identite'),
                'date_marquage'            =>  Utils::post('date_marquage'),
                'telephone'            =>  Utils::post('telephone'),
                'numero_bicycode'            =>  Utils::post('numero_bicycode'),
            ];

            $registre->addBicycode($data);
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

$tpl->assign('error', $error);

$tpl->display(PLUGIN_ROOT . '/templates/index.tpl');

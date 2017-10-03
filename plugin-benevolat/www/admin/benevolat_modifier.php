<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 03/10/2017
 * Time: 00:18
 */
 namespace Garradin;

 if ($user['droits']['membres'] < Membres::DROIT_ECRITURE)
 {
     throw new UserException("Vous n'avez pas le droit d'accéder à cette page.");
 }

 $benevolat = new Plugin\Benevolat\BD();

 $contribution = $benevolat->getEnregistrement((int) Utils::get('id'));
 $categories = $benevolat->getListeCategories();

 $error = false;

 if (!empty($_POST['add']))
 {
     if (!Utils::CSRF_check('edit_contribution'))
     {
         $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
     }
     else
     {
         try {
             $data = [
                 'nom_prenom'              =>  Utils::post('nom_prenom'),
                 'id_membre'     =>  Utils::post('id_membre'),
                 'date'         =>  Utils::post('date'),
                 'date_fin'         =>  Utils::post('date_fin'),
                 'plage'         =>  Utils::post('plage'),
                 'heures'           =>  Utils::post('heure'),
                 'id_categorie'    =>  Utils::post('id_categorie'),
                 'description'     =>  Utils::post('description'),
                 'id_membre_modif'     =>  $user['id'],
             ];

             $benevolat->editContribution($contribution['id'], $data);
             utils::redirect(PLUGIN_URL . 'index.php?edit_ben_ok');
         }
         catch (UserException $e)
         {
             $error = $e->getMessage();
         }
     }
 }

 $tpl->assign('error', $error);
 $tpl->assign('contribution', $contribution);
 $tpl->assign('categories', $categories);
 $tpl->display(PLUGIN_ROOT . '/templates/benevolat_modifier.tpl');

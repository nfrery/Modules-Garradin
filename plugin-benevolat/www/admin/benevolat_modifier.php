<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 03/10/2017
 * Time: 00:18
 */
 namespace Garradin;

 $session->requireAccess('config', Membres::DROIT_ECRITURE);


 $benevolat = new Plugin\Benevolat\BD();

 $contribution = (array)$benevolat->getEnregistrement(qg('id'));
 $categories = $benevolat->getListeCategories();

if(f('add') && $form->check('edit_contribution'))
{
         try {
             $date_fin = f('date_fin');
             if(f('plage') == 'on')
             {
                 $date_fin = null;
             }
             $data = [
                 'nom_prenom'       =>  f('nom_prenom'),
                 'id_membre'        =>  f('id_membre'),
                 'date'             =>  f('date'),
                 'date_fin'         =>  $date_fin,
                 'plage'            =>  f('plage'),
                 'heures'           =>  f('heure'),
                 'id_categorie'     =>  f('id_categorie'),
                 'description'      =>  f('description'),
                 'id_membre_modif'  =>  $session->getUser()->id,
             ];

             $benevolat->editContribution($contribution['id'], $data);
             utils::redirect(PLUGIN_URL . 'index.php?edit_ben_ok');
         }
         catch (UserException $e)
         {
             $form-addError ($e->getMessage());
         }
 }

 $tpl->assign('contribution', $contribution);
 $tpl->assign('categories', $categories);
 $tpl->display(PLUGIN_ROOT . '/templates/benevolat_modifier.tpl');

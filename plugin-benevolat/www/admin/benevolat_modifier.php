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

 $contribution = $benevolat->getEnregistrement(qg('id'));
 $categories = $benevolat->getListeCategories();

 if ($q = qg('q'))
 {
     $aResult = [];
     if (!empty($q))
     {
         $membres       = new Membres;
         $membres_liste = $membres->search('nom', $q);

         $i = 0;
         foreach ($membres_liste as $membre) {
             $a = (array)$membre;
             $aResult[$i]['id']    =  $a['id'];
             $aResult[$i]['value'] =  $a['nom'];
             if (!empty($a['email'])) {
                 $aResult[$i]['value'] .= ' (' . $a['email'] . ')';
             }
             $i++;
         }
     }
     echo json_encode($aResult);
     exit;
 }

 if(empty($contribution))
 {
     throw new UserException('Cette contribution n\'existe pas.');
 }

if(f('add') && $form->check('edit_contribution'))
{
    try {
        $data_benevolat = [
            'heures'         =>  f('nb_heures'),
            'id_categorie'      =>  f('id_categorie'),
            'id_benevole'       =>  f('id_benevole'),
            'nom_benevole'      =>  f('nom_benevole'),
            'description'       =>  f('description'),
            'date'              =>  f('date'),
            'plage'             =>  f('plage'),
            'date_fin'          =>  f('date_fin'),
        ];
        $data_journal = [
            'date'              =>  f('date'),
            'id_auteur'         =>  $session->getUser()->id,
            'id_projet'         =>  f('projet'),
            'id'                =>  $contribution->id_compta,
        ];

        $id = $benevolat->editContribution($contribution->id, $data_benevolat, $data_journal);
        utils::redirect(PLUGIN_URL . 'benevolat_voir.php?id='.$contribution->id.'&edit=ok');
    }
    catch (UserException $e)
    {
        $form->addError($e->getMessage());
    }
 }

 $tpl->assign('contribution', $contribution);
 $tpl->assign('categories', $categories);
 $tpl->assign('projets', (new Compta\Projets)->getAssocList());
 $tpl->display(PLUGIN_ROOT . '/templates/benevolat_modifier.tpl');

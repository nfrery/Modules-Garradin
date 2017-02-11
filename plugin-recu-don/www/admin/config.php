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

if (utils::post('save'))
{
    if (!utils::CSRF_check('config_plugin_' . $plugin->id()))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    else
    {
        try {
            $plugin->setConfig('droit_art200', (bool)utils::post('droit_art200'));
            $plugin->setConfig('droit_art238bis', (bool)utils::post('droit_art238bis'));
            $plugin->setConfig('droit_art885-0VbisA', (bool)utils::post('droit_art885-0VbisA'));
            $plugin->setConfig('numero_rue', (string)utils::post('numero_rue'));
            $plugin->setConfig('rue', (string)utils::post('rue'));
            $plugin->setConfig('codepostal', (string)utils::post('codepostal'));
            $plugin->setConfig('ville', (string)utils::post('ville'));
            $plugin->setConfig('objet0', (string)utils::post('objet0'));
            $plugin->setConfig('objet1', (string)utils::post('objet1'));
            $plugin->setConfig('objet2', (string)utils::post('objet2'));
            utils::redirect(PLUGIN_URL . 'config.php?ok');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
}

if (Utils::post('upload') || isset($_POST['uploadHelper_status']))
{
    if (!Utils::CSRF_check('signature'))
    {
        $error = 'Une erreur est survenue, merci de renvoyer le formulaire.';
    }
    elseif (Utils::post('uploadHelper_status') > 0)
    {
        $error = 'Un seul fichier peut être envoyé en même temps.';
    }
    elseif (!empty($_POST['fichier']) || isset($_FILES['fichier']))
    {
        try {
            if (isset($_POST['uploadHelper_status']) && !empty($_POST['fichier']))
            {
                $fichier = Fichiers::uploadExistingHash(Utils::post('fichier'), Utils::post('uploadHelper_fileHash'));
            }
            else
            {
                $fichier = Fichiers::upload($_FILES['fichier']);
            }

            // Lier le fichier à la page wiki
            //$fichier->linkTo(Fichiers::LIEN_WIKI, $page['id']);
            //$uri = '/admin/wiki/_fichiers.php?page=' . $page['id'] . '&sent';

            if (isset($_POST['uploadHelper_status']))
            {
                echo json_encode([
                    'redirect'  =>  WWW_URL,
                    'callback'  =>  'insertHelper',
                    'file'      =>  [
                        'image' =>  (int)$fichier->image,
                        'id'    =>  (int)$fichier->id,
                        'nom'   =>  $fichier->nom,
                        'thumb' =>  $fichier->image ? $fichier->getURL(200) : false
                    ],
                ]);
                exit;
            }
            if(!$plugin->getConfig('signaturetxt')==""){
            $fichier_old = new Fichiers($plugin->getConfig('signaturetxt'));
            $fichier_old->remove();
            }
            Static_Cache::storeFromUpload('fichiers.'.$fichier->id, $fichier->nom);
            $plugin->setConfig('signaturetxt', $fichier->id);
            Utils::redirect(PLUGIN_URL . 'config.php?ok');
        }
        catch (UserException $e)
        {
            $error = $e->getMessage();
        }
    }
    else
    {
        $error = 'Aucun fichier envoyé.';
    }

    if (isset($_POST['uploadHelper_status']))
    {
        echo json_encode(['error' => $error]);
        exit;
    }
}

if(!$plugin->getConfig('signaturetxt')==""){
    $img1 = new Fichiers($plugin->getConfig('signaturetxt'));
    $cache_id = 'fichiers.' . $img1->id_contenu;
        if (!Static_Cache::exists($cache_id))
        {
            $blob = DB::getInstance()->openBlob('fichiers_contenu', 'contenu', (int)$img1->id_contenu);
            Static_Cache::storeFromPointer($cache_id, $blob);
            fclose($blob);
        }

    $uri = $img1->getURL();
    $tpl->assign('image', $uri);
}
else{
    $tpl->assign('image', false);
}

$tpl->assign('error', $error);
$tpl->assign('max_size', Utils::getMaxUploadSize());

$tpl->display(PLUGIN_ROOT . '/templates/config.tpl');

<?php

namespace Garradin;

$error = false;

if (isset($_GET['ok']))
{
    $error = 'OK';
}

/*
$cats = new Membres\Categories;
	$champs = $config->get('champs_membres');

	$membres_cats = $cats->listSimple();
	$membres_cats_cachees = $cats->listHidden();

	$cat_id = (int) Utils::get('cat') ?: 0;
	$page = (int) Utils::get('p') ?: 1;

	if ($cat_id)
	{
	    if ($user['droits']['membres'] < Membres::DROIT_ECRITURE && array_key_exists($cat_id, $membres_cats_cachees))
	    {
	    	$cat_id = 0;
	    }
	}

	if (!$cat_id)
	{
	    $cat_id = array_diff(array_keys($membres_cats), array_keys($membres_cats_cachees));
	}
$order = 'nom';
$desc = false;

if (Utils::get('o'))
    $order = Utils::get('o');
if (isset($_GET['d']))
    $desc = true;

$fields = $champs->getListedFields();

	// Vérifier que le champ de tri existe bien dans la table
if (!array_key_exists($order, $fields))
{
	// Sinon par défaut c'est le premier champ de la table qui fait le tri
	$order = key($fields);
}

$tpl->assign('order', $order);
$tpl->assign('desc', $desc);

$tpl->assign('champs', $fields);

$tpl->assign('liste', $membres->listByCategory($cat_id, array_keys($fields), $page, $order, $desc));
$tpl->assign('total', $membres->countByCategory($cat_id));

$tpl->assign('pagination_url', Utils::getSelfUrl(true) . '?p=[ID]&amp;o=' . $order . ($desc ? '&amp;d' : '') . ($cat_id? '&amp;cat='. (int) Utils::get('cat') : ''));

$tpl->assign('membres_cats', $membres_cats);
$tpl->assign('membres_cats_cachees', $membres_cats_cachees);
$tpl->assign('current_cat', $cat_id);

$tpl->assign('page', $page);
$tpl->assign('bypage', Membres::ITEMS_PER_PAGE);
*/

$recus = new Plugin\RecuDon\GenDon;

$trecus = $recus->listSimple();

$test = print_r($trecus, true);

$tpl->assign('test',$test);
$tpl->assign('trecus', $trecus);
$tpl->assign('error', $error);
$tpl->display(PLUGIN_ROOT . '/templates/recu.tpl');

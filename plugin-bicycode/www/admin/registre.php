<?php

namespace Garradin;

$bicycode = new Plugin\Bicycode\Registre();
$liste = $bicycode->getBicycode();

$tpl->assign('liste', $liste);

$tpl->display(PLUGIN_ROOT . '/templates/registre.tpl');

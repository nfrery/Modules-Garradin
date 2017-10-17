<?php

namespace Garradin;

$session->requireAccess('config', Membres::DROIT_ADMIN);

$db = new Plugin\Benevolat\BD;

$ok = '';
if (isset($_GET['ok']))
{
    $ok = 'OK';
}

if(qg('export') !== null)
{
    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename="Export bénévolat - ' . $config->get('nom_asso') . ' - ' . date('Y-m-d') . '.csv"');
    $db->toCSV();
    exit;
}

if(f('config') && $form->check('modif_config'))
{
    try{
        $plugin->setConfig('soutien', (bool) f('soutien'));
        utils::redirect(PLUGIN_URL . 'config.php?ok');
    }
    catch (UserException $e)
    {
        $from->addError($e->getMessage());
    }
}

$tpl->assign('confirm', $ok);
$tpl->display(PLUGIN_ROOT . '/templates/config.tpl');

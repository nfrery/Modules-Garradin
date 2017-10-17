<?php

namespace Garradin;

$session->requireAccess('config', Membres::DROIT_ADMIN);

$tpl->display(PLUGIN_ROOT . '/templates/config.tpl');

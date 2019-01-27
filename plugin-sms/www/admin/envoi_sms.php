<?php

namespace Garradin;

use Garradin\Plugin\SMS\SMS;

$SMS = new SMS();

$SMS->envoi_sms();

$tpl->display(PLUGIN_ROOT . '/templates/envoi_sms.tpl');

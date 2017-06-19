<?php
namespace Garradin;

$plugin = new Plugin('mailchimp');
$plugin->registerSignal('membre.nouveau', 'Garradin\Plugin\MailChimp\Gestion::setMember');
//$plugin->registerSignal('membre.suppression', 'Garradin\Plugin\MailChimp\Gestion::delMember');
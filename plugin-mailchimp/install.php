<?php
namespace Garradin;

$plugin = new Plugin('mailchimp');
$plugin->registerSignal('membre.nouveau', 'Garradin\Plugin\MailChimp\Gestion::ajoutEditMembre');
$plugin->registerSignal('membre.edit', 'Garradin\Plugin\MailChimp\Gestion::ajoutEditMembre');
$plugin->registerSignal('membre.suppression', 'Garradin\Plugin\MailChimp\Gestion::supprMembre');
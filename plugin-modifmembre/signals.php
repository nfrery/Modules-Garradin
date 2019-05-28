<?php
namespace Garradin;

$plugin = new Plugin();

$plugin->registerSignal(cron.auto,'Garradin\Plugin\SQL::modifCategorie');
<?php
namespace Garradin;

$db = DB::getInstance(true);
$db->exec('BEGIN;');
$db->exec(file_get_contents(dirname(__FILE__) . "/data/schema_remove.sql"));
$db->exec('END;');

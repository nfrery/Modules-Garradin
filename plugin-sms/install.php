<?php
namespace Garradin;

$db = DB::getInstance();

$db->exec(file_get_contents(dirname(__FILE__) . "/data/schema.sql"));
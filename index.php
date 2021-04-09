<?php

ini_set("display_errors", "on");

error_reporting(E_ALL);

define("CLIENT_ROOT", dirname(__FILE__));

require_once CLIENT_ROOT . "/components/DB.php";

require_once CLIENT_ROOT . "/components/ClientRouter.php";

require_once CLIENT_ROOT . "/components/ClientConnectPartials.php";

require_once CLIENT_ROOT . "/controllers/ClientItemsController.php";

$Router = new ClientRouter();

$Router->run();



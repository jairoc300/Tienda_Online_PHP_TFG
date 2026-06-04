<?php

// Mostrar errores para debugging
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

date_default_timezone_set('Europe/Madrid');

session_start();
use Routes\Routes;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeload();

Routes::index();
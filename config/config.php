<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', getenv('BASE_URL') ?: ($protocol . '://' . $host . '/'));
define('MODO_DESARROLLO', getenv('MODO_DESARROLLO') === 'true');
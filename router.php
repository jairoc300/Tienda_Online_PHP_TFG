<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Las vistas usan BASE_URL.'public/css/...' — mapear /public/... al directorio real
if (strpos($uri, '/public/') === 0) {
    $strippedUri = substr($uri, 7);
    $file = __DIR__ . '/public' . $strippedUri;
    if (file_exists($file) && !is_dir($file)) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mime = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'ico'   => 'image/x-icon',
            'svg'   => 'image/svg+xml',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'webp'  => 'image/webp',
        ];
        if (isset($mime[$ext])) {
            header('Content-Type: ' . $mime[$ext]);
        }
        readfile($file);
        exit;
    }
}

// Archivos estáticos normales en public/
$file = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

require __DIR__ . '/public/index.php';
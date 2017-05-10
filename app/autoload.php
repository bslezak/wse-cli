<?php
$loader = null;

// Branch between installation by composer vs local package
if (file_exists($autoLoaderFile = __DIR__ . '/../../../autoload.php')) {
    $loader = require_once $autoLoaderFile;
} else {
    $loader = require_once __DIR__ . '/../vendor/autoload.php';
}

return $loader;

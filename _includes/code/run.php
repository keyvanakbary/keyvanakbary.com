#!/usr/bin/env php
<?php

function __autoload($className) {
    require_once $className . '.php';
}

function run($path, $fn) {
    foreach (glob($path) as $filepath) {
        $fn($filepath);
        set_include_path(dirname($filepath));
        include $filepath;
    }
}

run(__DIR__ . '/design-patterns/builder/*/usage*.php', function($filepath) {
    echo 'Running "' . $filepath . '"...' . "\n";
});

echo 'Done';
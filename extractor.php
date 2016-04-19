<?php

namespace extractor;

function files($dir) {
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false) {
        if (in_array($file, ['.', '..'])) {
            continue;
        }

        $file = $dir . '/' . $file;
        if (is_dir($file)) {
            foreach (files($file) as $child) {
                yield $child;
            }
        } else {
            yield $file;
        }
    }
    closedir($handle);
}

function lines($path) {
    $handle = fopen($path, 'r');
    if (!$handle) {
        throw new \RuntimeException('Cant read file "' . $path . '"');
    }
    while (($line = fgets($handle)) !== false) {
        yield $line;
    }
    fclose($handle);
}

function beautify($snippet) {
    $lines = explode("\n", $snippet);
    $first = current($lines);
    for($i = 0; $i < strlen($first); $i++) {
        if ($first[$i] != ' ') {
            break;
        }
    };

    $b = '';
    foreach ($lines as $line) {
        $b .= str_replace(str_repeat(' ', $i), '', $line) . "\n";
    }

    return trim($b);
}

function snippets($filename) {
    $snippet = '';
    $current = null;
    foreach (lines($filename) as $line) {
        $clean = trim($line);
        if ($clean == '//end-snippet') {
            yield $current => beautify($snippet);
            $current = null;
            $snippet = '';
        }
        if ($current) {
            $snippet .= $line;
        }
        if (preg_match('/\/\/snippet ([-a-zA-Z0-9]+)/', $clean, $matches) === 1) {
            $current = $matches[1];
        }
    }
}

function decamelize($word) {
    return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $word));
}

function remove($dir) {
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
    foreach (scandir($dir) as $file) {
        if (in_array($file, ['.', '..'])) {
            continue;
        }
        $filename = $dir . '/' . $file;
        if (!remove($filename)) {
            chmod($filename, 0777);
            if (!remove($filename)) {
                return false;
            }
        };
    }
    return rmdir($dir);
}

function dump(array $folders, $target, $fn) {
    remove($target);
    foreach ($folders as $folder) {
        foreach (files($folder) as $file) {
            $dir = str_replace(['src/', 'tests/'], '', decamelize(dirname($file))) . '/';
            foreach (snippets($file) as $name => $snippet) {
                $fn($dir . $name);
                @mkdir($target . $dir, 0777, true);
                file_put_contents($target . $dir . $name, $snippet);
            }
        }
    }
}

dump(['src', 'tests'], '_includes/snippet/', function($name) {
    echo $name . "\n";
});

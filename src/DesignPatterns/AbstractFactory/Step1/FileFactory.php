<?php

namespace DesignPatterns\AbstractFactory\Step1;

use SplFileObject;

//snippet file-factory
class FileFactory {
    public function createFile(string $filename, string $openMode) {
        return new SplFileObject($filename, $openMode);
    }
}
//end-snippet

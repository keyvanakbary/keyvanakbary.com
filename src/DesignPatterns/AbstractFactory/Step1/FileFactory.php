<?php

namespace DesignPatterns\AbstractFactory\Step1;

use SplFileObject;

//snippet file-factory
class FileFactory {
    public function createFile($filename, $openMode) {
        return new SplFileObject($filename, $openMode);
    }
}
//end-snippet

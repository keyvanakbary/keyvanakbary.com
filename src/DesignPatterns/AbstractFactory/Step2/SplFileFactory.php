<?php

namespace DesignPatterns\AbstractFactory\Step2;

//snippet spl-file-factory
class SplFileFactory implements FileFactory {
    public function createFile($filename, $openMode) {
        return new SplFile($filename, $openMode);
    }
}
//end-snippet

<?php

namespace DesignPatterns\AbstractFactory\Step2;

//snippet spl-file-factory
class SplFileFactory implements FileFactory {
    public function createFile(string $filename, string $openMode): File {
        return new SplFile($filename, $openMode);
    }
}
//end-snippet

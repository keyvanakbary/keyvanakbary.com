<?php

namespace DesignPatterns\AbstractFactory\Step2;

//snippet descriptor-file-factory
class DescriptorFileFactory implements FileFactory {
    public function createFile(string $filename, string $openMode): File {
        return new DescriptorFile($filename, $openMode);
    }
}
//end-snippet

<?php

namespace DesignPatterns\AbstractFactory\Step2;

//snippet file-factory
interface FileFactory {
    public function createFile(string $filename, string $openMode): File;
}
//end-snippet

<?php

namespace DesignPatterns\AbstractFactory\Step2;

//snippet file-factory
interface FileFactory {
    public function createFile($filename, $openMode);
}
//end-snippet

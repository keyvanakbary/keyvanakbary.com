<?php

namespace DesignPatterns\AbstractFactory\Step1;

//snippet file-writer
class HelloWorldFileWriter {
    private $fileFactory;

    public function __construct(FileFactory $fileFactory) {
        $this->fileFactory = $fileFactory;
    }

    public function writeTo(string $filepath): void {
        $file = $this->fileFactory->createFile($filepath, 'w+');
        $file->fwrite('Hello World!');
    }
}
//end-snippet

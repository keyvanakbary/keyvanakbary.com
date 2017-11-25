<?php

namespace DesignPatterns\AbstractFactory\Step2;

class HelloWorldFileWriter {
    private $fileFactory;

    public function __construct(FileFactory $fileFactory) {
        $this->fileFactory = $fileFactory;
    }

    public function writeTo(string $filepath): void {
        $file = $this->fileFactory->createFile($filepath, 'w+');
        //snippet update-file-writer
        $file->write('Hello World!');
        //end-snippet
    }
}

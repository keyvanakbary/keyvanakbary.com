<?php

namespace DesignPatterns\AbstractFactory\Step0;

use SplFileObject;

//snippet file-writer
class HelloWorldFileWriter {
    public function writeTo(string $filepath): void {
        $file = new SplFileObject($filepath, 'w+');
        $file->fwrite('Hello World!');
    }
}
//end-snippet

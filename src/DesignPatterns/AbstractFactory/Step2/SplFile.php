<?php

namespace DesignPatterns\AbstractFactory\Step2;

use SplFileObject;

//snippet spl-file
class SplFile implements File {
    private $file;

    public function __construct($filename, $openMode) {
        $this->file = new SplFileObject($filename, $openMode);
    }

    public function write(string $data): void {
        $this->file->fwrite($data);
    }
}
//end-snippet

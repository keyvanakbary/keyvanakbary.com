<?php

namespace DesignPatterns\AbstractFactory\Step2;

//snippet descriptor-file
class DescriptorFile implements File {
    private $fd;

    public function __construct($filename, $openMode) {
        $this->fd = fopen($filename, $openMode);
    }

    public function write(string $data): void {
        fwrite($this->fd, $data);
    }

    public function __destruct() {
        fclose($this->fd);
    }
}
//end-snippet

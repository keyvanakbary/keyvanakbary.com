<?php

namespace DesignPatterns\AbstractFactory\Step0;

use PHPUnit\Framework\TestCase;

class Step1Test extends TestCase {
    /**
     * @test
     */
    public function itShouldCreateFile(): void {
        //snippet file-writer-usage
        $writer = new HelloWorldFileWriter();
        $writer->writeTo('file.txt');
        //end-snippet

        $this->assertEquals('Hello World!', file_get_contents('file.txt'));
        unlink('file.txt');
    }
}

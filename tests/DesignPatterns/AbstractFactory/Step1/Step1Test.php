<?php

namespace DesignPatterns\AbstractFactory\Step1;

class Step1Test extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldCreateFile() {
        //snippet file-writer-usage
        $writer = new HelloWorldFileWriter(new FileFactory());
        $writer->writeTo('file.txt');
        //end-snippet

        $this->assertEquals('Hello World!', file_get_contents('file.txt'));
        unlink('file.txt');
    }
}

<?php

namespace DesignPatterns\AbstractFactory\Step1;

use Mockery;
use PHPUnit_Framework_TestCase;

//snippet file-writer-test
class HelloWorldFileWriterTest extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldWriteHelloWorld() {
        $writer = new HelloWorldFileWriter(
            $this->createFileFactoryStubWith(
                $file = new FileSpy()
            )
        );

        $writer->writeTo('irrelevant-file.txt');

        $this->assertEquals('Hello World!', $file->data);
    }

    private function createFileFactoryStubWith($file) {
        $stub = Mockery::mock(FileFactory::class);
        $stub->shouldReceive('createFile')->andReturn($file);

        return $stub;
    }
}

class FileSpy {
    public $data;

    public function fwrite($data) {
        $this->data = $data;
    }
}
//end-snippet

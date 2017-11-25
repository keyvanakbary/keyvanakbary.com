<?php

namespace DesignPatterns\AbstractFactory\Step2;

use Mockery;
use PHPUnit\Framework\TestCase;

class Step2Test extends TestCase {
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

    /**
     * @test
     */
    public function itShouldCreateFileThroughSpl() {
        //snippet file-writer-usage
        // Bootstrap
        $writer = new HelloWorldFileWriter(
            new SplFileFactory()           // PHP > 5.1.0
            // new DescriptorFileFactory() // PHP < 5.1.0
        );

        // Application
        $writer->writeTo('file.txt');
        //end-snippet

        $this->assertEquals('Hello World!', file_get_contents('file.txt'));
        unlink('file.txt');
    }

    /**
     * @test
     */
    public function itShouldCreateFileThroughDescriptor() {
        $writer = new HelloWorldFileWriter(new DescriptorFileFactory());

        $writer->writeTo('file.txt');

        $this->assertEquals('Hello World!', file_get_contents('file.txt'));
        unlink('file.txt');
    }
}

//snippet file-spy
class FileSpy implements File {
    public $data;

    public function write(string $data): void {
        $this->data = $data;
    }
}
//end-snippet

<?php

namespace DesignPatterns\AbstractFactory\Step1;

use Mockery;
use PHPUnit\Framework\TestCase;

//snippet file-writer-test
class HelloWorldFileWriterTest extends TestCase {
    /**
     * @test
     */
    public function itShouldWriteHelloWorld(): void {
        $writer = new HelloWorldFileWriter(
            $this->createFileFactoryStubWith(
                $file = new FileSpy()
            )
        );

        $writer->writeTo('irrelevant-file.txt');

        $this->assertEquals('Hello World!', $file->data);
    }

    private function createFileFactoryStubWith($file): FileFactory {
        $stub = Mockery::mock(FileFactory::class);
        $stub->shouldReceive('createFile')->andReturn($file);

        return $stub;
    }
}

class FileSpy {
    public $data;

    public function fwrite(string $data): void {
        $this->data = $data;
    }
}
//end-snippet

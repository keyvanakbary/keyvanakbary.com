<?php

namespace DesignPatterns\Factory\Step2;

use DesignPatterns\Factory\Step1\Snack;
use PHPUnit_Framework_TestCase;
use Mockery;

//snippet factory-test
class VendingMachineTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo() {
        $vendingMachine = new VendingMachine($this->createSnackFactoryStubWith(new SnackStub));

        $expected = <<<INFO
description: irrelevant
price: 0 euros
INFO;

        $this->assertEquals($expected, $vendingMachine->infoFor(0));
    }

    private function createSnackFactoryStubWith($snack) {
        $stub = Mockery::mock(new SnackFactory());
        $stub->shouldReceive('create')->andReturn($snack);

        return $stub;
    }
}

class SnackStub implements Snack {
    public function description() {
        return 'irrelevant';
    }

    public function price() {
        return 0;
    }
}
//end-snippet

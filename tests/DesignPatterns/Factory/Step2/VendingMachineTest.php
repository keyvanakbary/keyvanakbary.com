<?php

namespace DesignPatterns\Factory\Step2;

use DesignPatterns\Factory\Step1\Snack;
use PHPUnit\Framework\TestCase;
use Mockery;

//snippet factory-test
class VendingMachineTest extends TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo(): void {
        $vendingMachine = new VendingMachine($this->createSnackFactoryStubWith(new SnackStub));

        $expected = <<<INFO
description: irrelevant
price: 0 euros
INFO;

        $this->assertEquals($expected, $vendingMachine->infoFor(0));
    }

    private function createSnackFactoryStubWith(Snack $snack): SnackFactory {
        $stub = Mockery::mock(new SnackFactory());
        $stub->shouldReceive('create')->andReturn($snack);

        return $stub;
    }
}

class SnackStub implements Snack {
    public function description(): string {
        return 'irrelevant';
    }

    public function price(): float {
        return 0;
    }
}
//end-snippet

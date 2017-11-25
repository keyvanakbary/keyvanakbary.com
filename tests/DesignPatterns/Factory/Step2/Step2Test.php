<?php

namespace DesignPatterns\Factory\Step2;

use DesignPatterns\Factory\Step1\Snack;
use PHPUnit\Framework\TestCase;

class Step2Test extends TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo(): void {
        $m = new VendingMachine(new SnackFactory());
        $this->assertEquals($m->infoFor(1), <<<INFO
description: crunchy chips
price: 1.2 euros
INFO
        );
    }
}

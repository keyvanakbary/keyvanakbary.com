<?php

namespace DesignPatterns\Factory\Step0;

use PHPUnit\Framework\TestCase;

class Step0Test extends TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo(): void {
        //snippet vending-machine-usage
        $m = new VendingMachine();
        assert($m->infoFor(1) == <<<INFO
description: crunchy chips
price: 1.2 euros
INFO
        );
        //end-snippet
    }
}

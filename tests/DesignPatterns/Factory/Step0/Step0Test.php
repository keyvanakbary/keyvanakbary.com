<?php

namespace DesignPatterns\Factory\Step0;

use PHPUnit_Framework_TestCase;

class Step0Test extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo() {
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

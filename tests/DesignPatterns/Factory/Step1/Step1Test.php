<?php

namespace DesignPatterns\Factory\Step1;

class Step1Test extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo() {
        $m = new VendingMachine();
        assert($m->infoFor(1) == <<<INFO
description: crunchy chips
price: 1.2 euros
INFO
        );
    }
}

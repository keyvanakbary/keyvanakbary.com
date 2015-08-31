<?php

namespace DesignPatterns\Factory\Step2;

use DesignPatterns\Factory\Step1\Snack;

class Step2Test extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo() {
        $m = new VendingMachine(new SnackFactory());
        $this->assertEquals($m->infoFor(1), <<<INFO
description: crunchy chips
price: 1.2 euros
INFO
        );
    }
}

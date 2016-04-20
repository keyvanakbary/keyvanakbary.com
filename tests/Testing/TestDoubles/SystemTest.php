<?php

namespace Testing\TestDoubles;

use PHPUnit_Framework_TestCase;

//snippet dummy-test
class SystemTest extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function newlyCreatedSystemHasNoLoggedInUsers() {
        $system = new System(new DummyAuthorizer());

        $this->assertThat($system->loginCount(), $this->equalTo(0));
    }
}
//end-snippet

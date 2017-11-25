<?php

namespace Testing\TestDoubles;

use PHPUnit\Framework\TestCase;

//snippet dummy-test
class SystemTest extends TestCase {
    /**
     * @test
     */
    public function newlyCreatedSystemHasNoLoggedInUsers() {
        $system = new System(new DummyAuthorizer());

        $this->assertThat($system->loginCount(), $this->equalTo(0));
    }
}
//end-snippet

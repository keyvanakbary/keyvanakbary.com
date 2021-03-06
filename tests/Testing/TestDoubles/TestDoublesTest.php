<?php

namespace Testing\TestDoubles;

use PHPUnit\Framework\TestCase;

class TestDoublesTest extends TestCase {
    /**
     * @test
     */
    function stubShouldAuthorize(): void {
        $system = new LoginSystem($authorizer = new AcceptingAuthorizerStub());

        $out = $system->login('Joe', 'irrelevant');

        $this->assertThat($out, $this->equalTo('Hello Joe'));
    }

    /**
     * @test
     */
    function spyShouldNotBeCalled(): void {
        new LoginSystem($authorizer = new AcceptingAuthorizerSpy());

        $this->assertThat($authorizer->authorizeWasCalled, $this->isFalse());
    }

    /**
     * @test
     */
    function spyShouldBeCalled(): void {
        $system = new LoginSystem($authorizer = new AcceptingAuthorizerSpy());

        $out = $system->login('Joe', 'irrelevant');

        $this->assertThat($out, $this->equalTo('Hello Joe'));
        $this->assertThat($authorizer->authorizeWasCalled, $this->isTrue());
    }

    /**
     * @test
     */
    function fakeShouldAuthorize(): void {
        $system = new LoginSystem(new AcceptingAuthorizerFake());

        $out = $system->login('Bob', 'irrelevant');

        $this->assertThat($out, $this->equalTo('Hello Bob'));
    }

    /**
     * @test
     */
    function fakeShouldNotAuthorize(): void {
        $system = new LoginSystem(new AcceptingAuthorizerFake());

        $out = $system->login('Invalid', 'irrelevant');

        $this->assertThat($out, $this->equalTo('Not logged in'));
    }

    /**
     * @test
     */
    function mockShouldNotBeValid(): void {
        new LoginSystem($mock = new AcceptingAuthorizerVerificationMock());

        $this->assertThat($mock->verify(), $this->isFalse());
    }

    /**
     * @test
     */
    function mockShouldBeValid(): void {
        $system = new LoginSystem($mock = new AcceptingAuthorizerVerificationMock());

        $out = $system->login('Joe', 'irrelevant');

        $this->assertThat($out, $this->equalTo('Hello Joe'));
        $this->assertThat($mock->verify(), $this->isTrue());
    }
}

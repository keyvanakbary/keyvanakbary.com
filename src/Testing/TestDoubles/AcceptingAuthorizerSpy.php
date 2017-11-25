<?php

namespace Testing\TestDoubles;

//snippet authorizer-spy
class AcceptingAuthorizerSpy implements Authorizer {
    public $authorizeWasCalled = false;

    public function authorize(string $username, string $password): bool {
        $this->authorizeWasCalled = true;
        return true;
    }
}
//end-snippet

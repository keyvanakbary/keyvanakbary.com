<?php

namespace Testing\TestDoubles;

//snippet authorizer-spy
class AcceptingAuthorizerSpy implements Authorizer {
    public $authorizeWasCalled = false;

    public function authorize(string $user, string $pass): bool {
        $this->authorizeWasCalled = true;
        return true;
    }
}
//end-snippet

<?php

namespace Testing\TestDoubles;

//snippet authorizer-mock
class AcceptingAuthorizerVerificationMock implements Authorizer {
    public $authorizeWasCalled = false;

    public function authorize(string $user, string $pass): bool {
        $this->authorizeWasCalled = true;
        return true;
    }

    public function verify(): bool {
        return $this->authorizeWasCalled;
    }
}
//end-snippet

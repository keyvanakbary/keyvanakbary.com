<?php

namespace Testing\TestDoubles;

//snippet authorizer-mock
class AcceptingAuthorizerVerificationMock implements Authorizer {
    public $authorizeWasCalled = false;

    public function authorize($username, $password) {
        $this->authorizeWasCalled = true;
        return true;
    }

    public function verify() {
        return $this->authorizeWasCalled;
    }
}
//end-snippet

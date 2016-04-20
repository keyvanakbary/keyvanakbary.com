<?php

namespace Testing\TestDoubles;

//snippet authorizer-spy
class AcceptingAuthorizerSpy implements Authorizer {
    public $authorizeWasCalled = false;

    public function authorize($username, $password) {
        $this->authorizeWasCalled = true;
        return true;
    }
}
//end-snippet

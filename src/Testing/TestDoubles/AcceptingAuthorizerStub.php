<?php

namespace Testing\TestDoubles;

//snippet authorizer-stub
class AcceptingAuthorizerStub implements Authorizer {
    public function authorize($username, $password) {
        return true;
    }
}
//end-snippet

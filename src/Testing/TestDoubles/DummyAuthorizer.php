<?php

namespace Testing\TestDoubles;

//snippet dummy-authorizer
class DummyAuthorizer implements Authorizer {
    public function authorize(string $username, string $password): bool {
    }
}
//end-snippet

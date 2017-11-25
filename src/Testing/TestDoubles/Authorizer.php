<?php

namespace Testing\TestDoubles;

//snippet authorizer
interface Authorizer {
    public function authorize(string $username, string $password): bool;
}
//end-snippet

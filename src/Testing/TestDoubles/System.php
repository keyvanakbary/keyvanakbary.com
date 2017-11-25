<?php

namespace Testing\TestDoubles;

//snippet dummy-usage
class System {
    private $authorizer;

    public function __construct(Authorizer $authorizer) {
        $this->authorizer = $authorizer;
    }

    public function loginCount(): int {
        //some logic count calculation...
        return 0;
    }
}
//end-snippet

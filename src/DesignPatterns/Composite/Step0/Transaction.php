<?php

namespace DesignPatterns\Composite\Step0;

//snippet transaction
class Transaction {
    private $value;

    public function __construct(int $value) {
        $this->value = $value;
    }

    public function value(): int {
        return $this->value;
    }
}
//end-snippet

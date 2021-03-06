<?php

namespace DesignPatterns\Factory\Step2;

use DesignPatterns\Factory\Step1\Snack;

//snippet vending-machine
class VendingMachine {
    private $snackFactory;

    public function __construct(SnackFactory $snackFactory) {
        $this->snackFactory = $snackFactory;
    }

    public function infoFor(string $code): string {
        return $this->format($this->snackFactory->create($code));
    }

    private function format(Snack $snack): string {
        return
            'description: ' . $snack->description() . "\n" .
            'price: ' . $snack->price() . ' euros';
    }
}
//end-snippet

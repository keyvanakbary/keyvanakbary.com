<?php

namespace DesignPatterns\Factory\Step1;

//snippet vending-machine
class VendingMachine {
    public function infoFor(int $code): string {
        $snack = null;
        if ($code === 0) {
            $snack = new Chocolate;
        } elseif ($code === 1) {
            $snack = new Chips;
        } elseif ($code === 3) {
            $snack = new Sandwich;
        }

        return $this->format($snack);
    }

    private function format(Snack $snack): string {
        return
            'description: ' . $snack->description() . "\n" .
            'price: ' . $snack->price() . ' euros';
    }
}
//end-snippet

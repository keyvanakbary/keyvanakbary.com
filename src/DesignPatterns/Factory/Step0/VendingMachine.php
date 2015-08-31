<?php

namespace DesignPatterns\Factory\Step0;

//snippet vending-machine
class VendingMachine {
    public function infoFor($code) {
        $description = '';
        $price = '';
        if ($code === 0) {
            $description = 'delicious chocolate';
            $price = 1;
        } elseif ($code === 1) {
            $description = 'crunchy chips';
            $price = 1.2;
        } elseif ($code === 3) {
            $description = 'tasty sandwich';
            $price = 2.5;
        }

        return $this->format($description, $price);
    }

    private function format($description, $price) {
        return
            'description: ' . $description . "\n" .
            'price: ' . $price . ' euros';
    }
}
//end-snippet

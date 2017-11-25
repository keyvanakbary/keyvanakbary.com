<?php

namespace DesignPatterns\Builder;

//snippet burger
class Burger {
    private $patty;
    private $toppings = [];
    private $bun;

    public function setBun(string $bun): void {
        $this->bun = $bun;
    }

    public function setPatty(string $patty): void {
        $this->patty = $patty;
    }

    public function addToppings(array $toppings): void {
        $this->toppings = $toppings;
    }
}
//end-snippet

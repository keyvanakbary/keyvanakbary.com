<?php

namespace DesignPatterns\Builder;

//snippet burger
class Burger {
    private $patty;
    private $toppings = [];
    private $bun;

    public function setBun($bun) {
        $this->bun = $bun;
    }

    public function setPatty($patty) {
        $this->patty = $patty;
    }

    public function addToppings(array $toppings) {
        $this->toppings = $toppings;
    }
}
//end-snippet

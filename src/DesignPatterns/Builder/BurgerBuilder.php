<?php

namespace DesignPatterns\Builder;

//snippet burger-builder
abstract class BurgerBuilder {
    protected $burger;

    public function createBurger(): void {
        $this->burger = new Burger();
    }

    public function getBurger(): Burger {
        return $this->burger;
    }

    abstract public function prepareBun(): void;
    abstract public function cookPatty(): void;
    abstract public function putToppings(): void;
}
//end-snippet

<?php

namespace DesignPatterns\Builder;

//snippet american-burger-builder
class AmericanBurgerBuilder extends BurgerBuilder {
    public function prepareBun(): void {
        $this->burger->setBun('slider');
    }

    public function cookPatty(): void {
        $this->burger->setPatty('beef');
    }

    public function putToppings(): void {
        $this->burger->addToppings(['tomato', 'cheese', 'onion', 'pickles', 'bacon']);
    }
}
//end-snippet

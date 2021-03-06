<?php

namespace DesignPatterns\Builder;

//snippet veggie-burger-builder
class VeggieBurgerBuilder extends BurgerBuilder {
    public function prepareBun(): void {
        $this->burger->setBun('brioche');
    }

    public function cookPatty(): void {
        $this->burger->setPatty('halloumi');
    }

    public function putToppings(): void {
        $this->burger->addToppings(['cauliflower', 'tomato', 'onion', 'cheese']);
    }
}
//end-snippet

<?php

class AmericanBurgerBuilder extends BurgerBuilder {
    public function prepareBun() {
        $this->burger->setBun('slider'); 
    }
 
    public function cookPatty() {
        $this->burger->setPatty('beef'); 
    }
 
    public function putToppings() {
        $this->burger->addToppings(['tomato', 'cheese', 'onion', 'pickles', 'bacon']); 
    }
}

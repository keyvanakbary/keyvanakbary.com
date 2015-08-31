<?php

class VeggieBurgerBuilder extends BurgerBuilder {
    public function prepareBun() {
        $this->burger->setBun('brioche'); 
    }
 
    public function cookPatty() {
        $this->burger->setPatty('halloumi'); 
    }
 
    public function putToppings() {
        $this->burger->addToppings(['cauliflower', 'tomato', 'onion', 'cheese']); 
    }
}

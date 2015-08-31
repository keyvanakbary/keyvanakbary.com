<?php

abstract class BurgerBuilder {
    protected $burger;
 
    public function createBurger() {
        $this->burger = new Burger();
    }
 
    public function getBurger() {
        return $this->burger;
    }
 
    abstract public function prepareBun();
    abstract public function cookPatty();
    abstract public function putToppings();
}

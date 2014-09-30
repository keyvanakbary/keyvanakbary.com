---
layout: post
title: "Patrón Builder"
description:
    El patrón builder entra dentro de la categoría de patrones de creación. Esto significa que su uso esta ideado para construir objetos. La idea primigenia plasmada en el ya clásico Gang of Four, gira entorno a desacoplar el código de construcción del código de representación.
---

El patrón builder entra dentro de la categoría de patrones de creación. Esto significa que su uso esta ideado para construir objetos. La idea primigenia plasmada en el ya clásico [Gang of Four](http://www.amazon.com/Design-Patterns-Elements-Reusable-Object-Oriented/dp/0201633612), **gira entorno a desacoplar el código de construcción del código de representación**.

> Abstrae el proceso de creación de un objeto complejo, centralizando dicho proceso en un único punto, de tal forma que el mismo proceso de construcción pueda crear representaciones diferentes.

Las clases internas que participan en la construcción del objeto no forman parte del api público del *Builder*. El cliente no tiene porqué saber los detalles de cómo construir un objeto complejo. El uso de este patrón también alivia la congestión de métodos con muchos parámetros.

Por ejemplo, si disponemos de un objeto o *producto* cuya construcción es relativamente compleja, como una abstracta y deliciosa hamburguesa

{% highlight php startinline %}
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
{% endhighlight %}

Y necesitamos cocinarla de diferentes maneras según la receta; podemos crear un *abstract Builder* que se especialize según la receta con *implementaciones concretas* haciendo uso del [patrón template method](http://en.wikipedia.org/wiki/Template_method_pattern)

{% highlight php startinline %}
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
{% endhighlight %}

Como una hamburgesa vegetariana 

{% highlight php startinline %}
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
{% endhighlight %}

O una americana...

{% highlight php startinline %}
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
{% endhighlight %}

El *director*, es decir, el chef, controla y gestiona de forma precisa el proceso de creación del *producto*

{% highlight php startinline %}
class BurgerChef {
    public function makeBurger(BurgerBuilder $builder) {
        $builder->createBurger();
        $builder->prepareBun();
        $builder->cookPatty();
        $builder->putToppings();
 
        return $builder->getBurger();
    }
}
{% endhighlight %}

El *cliente* queda entonces liberado de detalles de construcción

{% highlight php startinline %}
$chef = new BurgerChef();
$vegieBurger = $chef->makeBurger(new VeggieBurgerBuilder());
$americanBurger = $chef->makeBurger(new AmericanBurgerBuilder());
{% endhighlight %}

## Constructor Telescópico

Un problema especialmente conocido en lenguajes con [sobrecarga de métodos](http://en.wikipedia.org/wiki/Function_overloading) como Java, C# o C++ es el famoso efecto del constructor telescópico. En PHP no podemos sobrecargar métodos pero si podemos entender el problema si evitamos pasar argumentos opcionales al constructor a base de añadir [factory methods](http://en.wikipedia.org/wiki/Factory_method_pattern). Añadir argumentos al constructor provoca un incremento exponencial en la definición de métodos de inicialización.

{% highlight php startinline %}
class User {
    private $username;
    private $password;
    private $email;
    private $name;

    private function __construct($username, $password, $email = '', $name = '') {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
    }

    public static function create($username, $password) {
        return new self($username, $password);
    }

    public static function createWithEmail($username, $password, $email) {
        return new self($username, $password, $email);
    }

    public static function createWithName($username, $password, $name) {
        return new self($username, $password, '', $name);
    }

    public static function createWithEmailAndName($username, $password, $email, $name) {
        return new self($username, $password, $email, $name);
    }
}
{% endhighlight %}

Añadir más argumentos al constructor incrementa el problema exponencialmente. Delegando en un *Builder* la construcción de `User` y haciendo uso de [interfaz fluida](http://en.wikipedia.org/wiki/Fluent_interface) aliviamos enormemente la complejidad del sistema. El trade-off es que exponemos al constructor del objeto que construyamos para que sea visible desde el *Builder*.

{% highlight php startinline %}
class UserBuilder {
    private $username;
    private $password;
    private $email = '';
    private $name = '';

    private function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    private static function aUser($username, $password) {
        return new self($username, $password);
    }

    public function withName($name) {
        $this->name = $name;

        return $this;
    }

    public function withEmail($email) {
        $this->email = $email;

        return $this;
    }

    public function build() {
        return new User($this->username, $this->password, $this->email, $this->name);
    }
}
{% endhighlight %}

Crear un `User` sin nombre ni email es tan sencillo como

{% highlight php startinline %}
$user = UserBuilder::aUser('keyvan', 'pass')->build();
{% endhighlight %}

De la misma forma, añadir los parámetros opcionales es tan fácil como

{% highlight php startinline %}
$user = UserBuilder::aUser('keyvan', 'pass')
    ->withName('Keyvan Akbary')
    ->withEmail('keyvan@example.com')
    ->build();
{% endhighlight %}

#### Referencias

- [Gang of Four](http://www.amazon.com/Design-Patterns-Elements-Reusable-Object-Oriented/dp/0201633612)
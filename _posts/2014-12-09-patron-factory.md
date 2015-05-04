---
layout: post
title: "Patrón Factory"
references:
    - {title: "Gang of Four", url: "http://amzn.to/1vIk2QL"}
---

Probablemente uno de los patrones más utilizados en lenguajes de programación modernos. El patrón Factory, una variante actual de los patrones de creación definidos en [Gang of Four](http://www.amazon.com/Design-Patterns-Elements-Reusable-Object-Oriented/dp/0201633612) como [Factory Method](http://en.wikipedia.org/wiki/Factory_method_pattern) y [Abstract Factory](/patron-abstract-factory/), **permite desacoplar la lógica de creación de forma centralizada**.

<!--more-->

> Responsable de crear objetos evitando exponer la lógica de instanciación al cliente.

Como ejemplo, si reflexionamos sobre el siguiente código

{% highlight php startinline %}
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

$m = new VendingMachine;
echo $m->infoFor(1);
//description: crunchy chips
//price: 1.2 euros
{% endhighlight %}

Podemos llegar a la conclusión de que esta implementación tiene algunos problemas. Una máquina expendedora ofrece productos concretos, sin embargo no hay una unidad que represente un producto en el sistema.

Un producto esta representado por una descripción y un precio que estan esparcidos por el método que muestra la información de producto. Además, resulta que toda esta información referente a los productos se encuentra en el propio método. El método encargado de mostrar la información es el mismo que la crea. Añadir una propiedad más al producto, extender el comportamiento o reutilizar la información en otros lugares complicará más el código.

Podemos definir una interfaz común a todos los productos, y definirlos de la siguiente manera

{% highlight php startinline %}
interface Snack {
    public function description();
    public function price();
}

class Chocolate implements Snack {
    public function description() {
        return 'delicious chocolate';
    }

    public function price() {
        return 1;
    }
}

class Chips implements Snack {
    public function description() {
        return 'crunchy chips';
    }

    public function price() {
        return 1.2;
    }
}

class Sandwich implements Snack {
    public function description() {
        return 'tasty sandwich';
    }

    public function price() {
        return 2.5;
    }
}
{% endhighlight %}

Parece que ahora nuestro el código parece más claro y concisco.

{% highlight php startinline %}
class VendingMachine {
    public function infoFor($code) {
        $snack = null;
        if ($code === 0) {
            $snack = new Chocolate;
        } elseif ($code === 1) {
            $snack = new Chips;
        } elseif ($code === 3) {
            $snack = new Sandwich;
        }

        return $this->format($snack);
    }

    private function format(Snack $snack) {
        return
            'description: ' . $snack->description() . "\n" .
            'price: ' . $snack->price() . ' euros';
    }
}
{% endhighlight %}

La lógica de creación de productos esta fuertemente acoplada con el método responsable de mostrar la propia información. La única forma de incorporar un nuevo producto es la de incorporar un nuevo bloque `elseif` a este método.

No es responsabilidad del método que muestra la información de producto la de crear los propios productos.

## Desacoplando la lógica de creación
Haciendo uso del **patrón Factory**, podemos extraer la lógica de creación a una clase dedicada exclusivamente a ello.

{% highlight php startinline %}
class SnackFactory {
    public function create($code) {
        switch($code) {
            case 0:
                return new Chocolate;
            case 1:
                return new Chips;
            case 2:
                return new Sandwich;
        }

        throw new Exception('No snack for code ' . $code);
    }
}
{% endhighlight %}

El código cliente queda entonces liberado de la lógica de creación.

{% highlight php startinline %}
class VendingMachine {
    private $snackFactory;

    public function __construct(SnackFactory $snackFactory) {
        $this->snackFactory = $snackFactory;
    }

    public function infoFor($code) {
        return $this->format($this->snackFactory->create($code));
    }

    private function format(Snack $snack) {
        return
            'description: ' . $snack->description() . "\n" .
            'price: ' . $snack->price() . ' euros';
    }
}
{% endhighlight %}

Añadir o eliminar un producto del catálogo es tan sencillo como modificar la Factory. Cambios en el catálogo ya no afectarán a la máquina expendedora. Ahora la lógica de creación esta desacoplada de la lógica de negocio y puede evolucionar de forma independiente.

## Testing
Como beneficio añadido, el hecho de desacoplar la lógica de creación nos permite reemplazar la Factory por un [test double](/test-doubles/) en nuestros tests. Ahora podemos forzar un determinado flujo en el *System Under Test* para probar todos los casos.

{% highlight php startinline %}
class VendingMachineTest extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldComposeSnackInfo() {
        $vendingMachine = new VendingMachine($this->createSnackFactoryStubWith(new SnackStub));
        
        $expected = <<<INFO
description: irrelevant
price: 0 euros
INFO;

        $this->assertEquals($expected, $vendingMachine->info(0));
    }

    private function createSnackFactoryStubWith($snack) {
        $stub = Mockery::mock('SnackFactory');
        $stub->shouldReceive('create')->andReturn($snack);

        return $stub;
    }
}

class SnackStub implements Snack {
    public function description() {
        return 'irrelevant';
    }

    public function price() {
        return 0;
    }
}
{% endhighlight %}

No tengo por qué acoplar mi test a un producto real. Sabiendo que mi test va a probar la información que ofrece la máquina expendedora sobre un determinado producto, me basta con un generar un [Stub](/test-doubles/) para este caso concreto.

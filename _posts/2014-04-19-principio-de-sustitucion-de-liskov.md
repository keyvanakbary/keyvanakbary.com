---
layout: post
title: "Principio de Sustitución de Liskov"
description:
    El Principio de Sustitución de Liskov, o LSP, corresponde a la sigla L dentro de los 5 principios SOLID para la programación orientada a objetos. “Los subtipos deberían poder ser reemplazables por sus tipos base”
redirect_from:
    - /principio-de-substitucion-de-liskov/
---

El Principio de Sustitución de Liskov, o LSP (Liskov Substitution Principle), corresponde a la sigla L dentro de los 5 principios [SOLID](http://wikipedia.com/SOLID) para la programación orientada a objetos.

> Los subtipos deberían poder ser reemplazables por sus tipos base

[Bárbara Liskov](http://en.wikipedia.org/wiki/Barbara_Liskov) describió por primera vez este principio en 1988
> Lo que queremos es algo parecido a la siguiente propiedad sustitutiva: Si por cada objeto <code>O<sub>1</sub></code> de tipo `S` hay un objeto <code>O<sub>2</sub></code> de tipo `T` tal que todos los programas `P` estan definidos en términos de `T`, el comportamiento de `P` no cambia cuando <code>O<sub>1</sub></code> es sustituido por <code>O<sub>2</sub></code> siendo `S` un subtipo de `T`

La importancia de este principio se hace evidente cuando pensamos en las consecuencias de violarla. Piensa en que tenemos una función `f` que toma como argumento un tipo base `B`. Considera que el tipo `B` tiene un derivado `D`, que cuando se pasa a `f` se comporta de forma incorrecta. Es en este caso cuando podemos asegurar que `D` no puede reemplazar a `B`.

## Ejemplo de violación de LSP
Considera el siguiente código como parte de una aplicación

{% highlight php startinline %}
class Rectangle {
    private $width;
    private $height;

    public function setWidth($width) {
        $this->width = $width;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function area() {
        return $this->width * $this->height;
    }
}
{% endhighlight %}

Supongamos que el código funciona correctamente en diversos lugares de la aplicación. Alguien reclama una nueva funcionalidad, ahora existe la posibilidad de manipular **cuadrados** además de rectángulos.

A menudo en el mundo de la programación orientada a objetos la herencia se interpreta a través de relaciones del tipo *ES-UN*. Miremos como lo miremos, un cuadrado matemáticamente **es un** rectángulo. No es descabellado llegar a la conclusión de que en nuestro modelo un cuadrado debe extender de rectángulo.

{% highlight php startinline %}
class Square extends Rectangle {
    //...
}
{% endhighlight %}

Sin embargo, esta forma de pensar puede conducirnos a grandes quebraderos de cabeza. En nuestro ejemplo, es fácil darnos cuenta de que `Square` no necesita de ambas propiedades `$width` o `$height`, nos bastaría con sencillo `$size` dado que el alto y ancho de un cuadrado se mantienen iguales. Imaginemos una aplicación con millones de estos objetos, un gasto significativo de memoria sin lugar a dudas.

Asumamos que por ahora no nos importa mucho el consumo de memoria. Al heredar de `Rectangle` heredamos inmediatamente sus métodos `setWidth` y `setHeight` que introducen un punto de incongruencia a nuestro código dado que no existe la posibilidad de tener ancho y alto diferentes. Sin embargo podemos esquivar el problema sobreescribiendo los métodos de la siguiente forma:

{% highlight php startinline %}
class Square extends Rectangle {
    public function setWidth($width) {
        parent::setWidth($width);
        parent::setHeight($width);
    }

    public function setHeight($height) {
        parent::setHeight($height);
        parent::setWidth($height);
    }
}
{% endhighlight %}

Ahora cuando alguien utilice las propiedades `setWidth` o `setHeight` se mantendrá consistente con la definición de cuadrado.

{% highlight php startinline %}
$square = new Square;
$square->setWidth(1);//width, height = 1
$square->setheight(2);//height, width = 2
{% endhighlight %}

### El problema
Ahora que el código es consistente con la definición matemática de cuadrado, considera que pasamos un cuadrado a la siguiente función

{% highlight php startinline %}
function g(Rectangle $r) {
    $r->setWidth(5);
    $r->setHeight(4);
    assert($r->area() == 20);
}
{% endhighlight %}

Aunque el cuadrado sea consistente con su definición, no lo es respecto a todos los casos y usuarios. Este código es una clara violación del LSP.

### ES-UN se trata de comportamiento
Entonces, ¿cual fué el problema? ¿acaso un cuadrado no *es un* rectángulo?

Desde el punto de vista del autor de la función `g` parece que no. Desde el punto de vista de `g` el comportamiento del objeto `Square` no es consistente con el comportamiento de un objeto `Rectangle`. Desde el punto de vista del comportamiento `Square` definitivamente no es un `Rectangle`.

## Heurísticas y convenciones
Hay algunas heurísticas que te pueden ayudar a encontrar violaciones del principio de Liskov. Todas tienen que ver con clases derivadas que de alguna forma eliminan o corrompen la funcionalidad de las clases base.

### Funciones degenerativas en derivadas
{% highlight php startinline %}
class Base {
    public function f() {
        //some code
    }
}

class Derived extends Base {
    public function f() {}
}
{% endhighlight %}

El autor de `Derived` ha considerado que el método `f` no es necesario. Por desgracia, los usuarios que hagan uso de `Base` no saben que no deberían llamar al método `f`, esto es una clara violación de LSP.

### Lanzar excepciones en derivadas
Otra causa común de violación del LSP es el lanzar excepciones en clases derivadas cuyas clases base no lanzan. Si los usuarios de las clases base no esperan excepciones, añadirlas provocará que no sean sustituibles.

#### Referencias
- [Clean Code](http://www.amazon.com/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882)
- [Agile Software Development](http://www.amazon.com/Software-Development-Principles-Patterns-Practices/dp/0135974445)
- [Barbara Liskov Interview](http://www.infoq.com/interviews/barbara-liskov)
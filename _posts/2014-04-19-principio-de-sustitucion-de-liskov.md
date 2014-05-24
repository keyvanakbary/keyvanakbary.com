---
layout: post
title: "Principio de Sustitución de Liskov"
description:
    El Principio de Sustitución de Liskov, o LSP, corresponde a la sigla L dentro de los 5 principios SOLID para la programación orientada a objetos.
    
    “Los subtipos deberían poder ser reemplazables por sus tipos base”
redirect_from:
    - /principio-de-substitucion-de-liskov/
---

El Principio de Sustitución de Liskov, o LSP (Liskov Substitution Principle), corresponde a la sigla L dentro de los 5 principios [SOLID](http://wikipedia.com/SOLID) para la programación orientada a objetos.

> Los subtipos deberían poder ser reemplazables por sus tipos base

La importancia de este principio se hace evidente cuando pensamos en las consecuencias de violarla.

Piensa en que tenemos una función `f` que toma como argumento un tipo base `B`. Considera que el tipo `B` tiene un derivado `D`, que cuando se pasa a `f` se comporta de forma errónea. Es en este caso cuando podemos asegurar que `D` viola LSP.

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

A menudo en el mundo de la POO la herencia se interpreta a través de relaciones del tipo *ES-UN*. Miremos como lo miremos, un cuadrado matemáticamente **es un** rectángulo. No es descabellado llegar a la conclusión de que en nuestro modelo un cuadrado debe extender de rectángulo.

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
---
layout: post
title: "Patrón Factory"
references:
    - {title: "Gang of Four", url: "http://amzn.to/1vIk2QL"}
---

Probablemente uno de los patrones más utilizados en lenguajes de programación modernos. El patrón Factory, una variante actual de los patrones de creación definidos en [Gang of Four](http://www.amazon.com/Design-Patterns-Elements-Reusable-Object-Oriented/dp/0201633612) como [Factory Method](http://en.wikipedia.org/wiki/Factory_method_pattern) y [Abstract Factory](/patron-abstract-factory/), **permite desacoplar la lógica de creación de forma centralizada**.

<!--more-->

> Responsable de crear objetos evitando exponer la lógica de instanciación al cliente.

Como ejemplo, si analizamos el siguiente código

{% include snippet.html file="design-patterns/factory/step0/vending-machine" %}

{% include snippet.html file="design-patterns/factory/step0/vending-machine-usage" %}

Podemos llegar a la conclusión de que esta implementación tiene algunos problemas. Una máquina expendedora ofrece productos concretos, sin embargo no hay una unidad que represente un producto en el sistema.

Un producto esta representado por una descripción y un precio que estan esparcidos por el método que muestra la información de producto. Además, resulta que toda esta información referente a los productos se encuentra en el propio método. El método encargado de mostrar la información es el mismo que la crea. Añadir una propiedad más al producto, extender el comportamiento o reutilizar la información en otros lugares complicará más el código.

Podemos definir una interfaz común a todos los productos, y definirlos de la siguiente manera

{% include snippet.html file="design-patterns/factory/step1/snacks" %}

Parece que ahora nuestro el código parece más claro y concisco.

{% include snippet.html file="design-patterns/factory/step1/vending-machine" %}

La lógica de creación de productos esta fuertemente acoplada con el método responsable de mostrar la propia información. La única forma de incorporar un nuevo producto es la de incorporar un nuevo bloque `elseif` a este método.

No es responsabilidad del método que muestra la información de producto la de crear los propios productos.

## Desacoplando la lógica de creación
Haciendo uso del **patrón Factory**, podemos extraer la lógica de creación a una clase dedicada exclusivamente a ello.

{% include snippet.html file="design-patterns/factory/step2/snack-factory" %}

El código cliente queda entonces liberado de la lógica de creación.

{% include snippet.html file="design-patterns/factory/step2/vending-machine" %}

Añadir o eliminar un producto del catálogo es tan sencillo como modificar la Factory. Cambios en el catálogo ya no afectarán a la máquina expendedora. Ahora la lógica de creación esta desacoplada de la lógica de negocio y puede evolucionar de forma independiente.

## Testing
Como beneficio añadido, el hecho de desacoplar la lógica de creación nos permite reemplazar la Factory por un [test double](/test-doubles/) en nuestros tests. Ahora podemos forzar un determinado flujo en el *System Under Test* para probar todos los casos.

{% include snippet.html file="design-patterns/factory/step2/factory-test" %}

No tengo por qué acoplar mi test a un producto real. Sabiendo que mi test va a probar la información que ofrece la máquina expendedora sobre un determinado producto, me basta con un generar un [Stub](/test-doubles/) para este caso concreto.

---
layout: post
title: "Patrón Builder"
references:
    - {title: "Gang of Four", url: "http://amzn.to/1vIk2QL"}
---

El patrón builder entra dentro de la categoría de patrones de creación. Esto significa que su uso esta ideado para construir objetos. La idea primigenia plasmada en el ya clásico [Gang of Four](http://amzn.to/1rYJuSn), **gira entorno a desacoplar el código de construcción del código de representación**.

<!--more-->

> Abstrae el proceso de creación de un objeto complejo, centralizando dicho proceso en un único punto, de tal forma que el mismo proceso de construcción pueda crear representaciones diferentes.

Las clases internas que participan en la construcción del objeto no forman parte del api público del *Builder*. El cliente no tiene por qué saber los detalles de cómo construir un objeto complejo. El uso de este patrón también alivia la congestión de métodos con muchos parámetros.

Por ejemplo, si disponemos de un objeto o *producto* cuya construcción es relativamente compleja, como una abstracta y deliciosa hamburguesa

{% include snippet.html file="design-patterns/builder/abstract-builder/Burger.php" %}

Y necesitamos cocinarla de diferentes maneras según la receta; podemos crear un *abstract Builder* que se especialize según la receta con *implementaciones concretas* haciendo uso del [patrón template method](http://en.wikipedia.org/wiki/Template_method_pattern)

{% include snippet.html file="design-patterns/builder/abstract-builder/BurgerBuilder.php" %}

Como una hamburgesa vegetariana 

{% include snippet.html file="design-patterns/builder/abstract-builder/VeggieBurgerBuilder.php" %}

O una americana...

{% include snippet.html file="design-patterns/builder/abstract-builder/AmericanBurgerBuilder.php" %}

El *director*, es decir, el chef, controla y gestiona de forma precisa el proceso de creación del *producto*

{% include snippet.html file="design-patterns/builder/abstract-builder/BurgerChef.php" %}

El *cliente* queda entonces liberado de detalles de construcción

{% include snippet.html file="design-patterns/builder/abstract-builder/usage.php" %}

## Constructor Telescópico

Un problema especialmente conocido en lenguajes con [sobrecarga de métodos](http://en.wikipedia.org/wiki/Function_overloading) como Java, C# o C++ es el famoso efecto del constructor telescópico. En PHP no podemos sobrecargar métodos pero si podemos entender el problema si evitamos pasar argumentos opcionales al constructor a base de añadir [factory methods](http://en.wikipedia.org/wiki/Factory_method_pattern). Añadir argumentos al constructor provoca un incremento exponencial en la definición de métodos de inicialización.

{% include snippet.html file="design-patterns/builder/telescopic-constructor/User.php" %}

Añadir más argumentos al constructor incrementa el problema exponencialmente. Delegando en un *Builder* la construcción de `User` y haciendo uso de [interfaz fluida](http://en.wikipedia.org/wiki/Fluent_interface) aliviamos enormemente la complejidad del sistema. El trade-off es que exponemos al constructor del objeto que construyamos para que sea visible desde el *Builder*.

{% include snippet.html file="design-patterns/builder/telescopic-constructor/UserBuilder.php" %}

Crear un `User` sin nombre ni email es tan sencillo como

{% include snippet.html file="design-patterns/builder/telescopic-constructor/usage-mandatory.php" %}

De la misma forma, añadir los parámetros opcionales es tan fácil como

{% include snippet.html file="design-patterns/builder/telescopic-constructor/usage-optional.php" %}

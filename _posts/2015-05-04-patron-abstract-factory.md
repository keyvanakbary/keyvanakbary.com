---
layout: post
title: "Patrón Abstract Factory"
references:
    - {title: "Gang of Four", url: "http://amzn.to/1vIk2QL"}
---

El patrón Abstract Factory, se encuentra dentro de los denominados patrones de creación. Como define el ya clásico [Gang of Four](http://amzn.to/1vIk2QL), **nos permite desacoplar y flexibilizar la lógica de creación permitiendo múltiples implementaciones**.

<!--more-->

> Abstract Factory ofrece una interfaz común para crear una familia de objetos relacionados sin exponer directamente sus clases.

Consideremos el siguiente ejemplo. Un servicio que crea o sobreescribe el fichero que el usuario especifica con el ya clásico “Hello World!”

{% include snippet.html file="design-patterns/abstract-factory/step0/file-writer" %}

{% include snippet.html file="design-patterns/abstract-factory/step0/file-writer-usage" %}

Tiene un pequeño inconveniente, este código no se puede testear de forma unitaria, esto es, sin tener que crear un fichero realmente. El servicio esta acoplado directamente a la creación de `SplFileObject`.

Podemos extraer la lógica de creación haciendo uso del patrón [Factory](/patron-factory/)

{% include snippet.html file="design-patterns/abstract-factory/step1/file-factory" %}

{% include snippet.html file="design-patterns/abstract-factory/step1/file-writer" %}

{% include snippet.html file="design-patterns/abstract-factory/step1/file-writer-usage" %}

Haciendo uso de [Duck Typing](http://en.wikipedia.org/wiki/Duck_typing) y [Mockery](https://github.com/padraic/mockery) podemos reemplazar la abstracción `SplFileObject` por un [Test Double](/test-doubles/) espía en nuestros tests

{% include snippet.html file="design-patterns/abstract-factory/step1/file-writer-test" %}

## Multiples Implementaciones
Ahora bien, la abstracción `SplFileObject` [no se introdujo hasta la versión de PHP 5.1.0](http://php.net/manual/en/class.splfileobject.php). Como ejemplo ilustrativo, imaginemos que algunos de nuestros clientes siguen utilizando la versión de PHP 5.0.0. Podemos crear una nueva implementación para la abstracción del sistema de ficheros basada en los clásicos descriptores de fichero para ellos.

El primer paso es definir una interfaz común para la abstracción del sistema de ficheros con la que exponer un contrato claro e independiente al de `SplFileObject` sobre el cual tengamos control total

{% include snippet.html file="design-patterns/abstract-factory/step2/file" %}

Encapsulamos la actual implementación de `SplFileObject` destinada a clientes con una versión de PHP mayor a la 5.1.0

{% include snippet.html file="design-patterns/abstract-factory/step2/spl-file" %}

Y definimos una nueva implementación basada en descriptores para los clientes con PHP menor a la 5.1.0

{% include snippet.html file="design-patterns/abstract-factory/step2/descriptor-file" %}

De la misma forma, podemos crear dos provedores de abstracciones de ficheros. Esto es, podemos crear un **Abstract Factory** con múltiples implementaciones

{% include snippet.html file="design-patterns/abstract-factory/step2/file-factory" %}

{% include snippet.html file="design-patterns/abstract-factory/step2/descriptor-file-factory" %}

{% include snippet.html file="design-patterns/abstract-factory/step2/spl-file-factory" %}

Solo es necesario adaptar nuestro código a la nueva interfaz en el servicio `HelloWorldFileWriter`

{% include snippet.html file="design-patterns/abstract-factory/step2/update-file-writer" %}

Y en los tests, simplemente cumplir con la interfaz

{% include snippet.html file="design-patterns/abstract-factory/step2/file-spy" %}

Ahora es el cliente el que puede elegir que **Factory** utilizar según su versión de PHP sin que ello afecte en absoluto a la ejecución de nuestro servicio

{% include snippet.html file="design-patterns/abstract-factory/step2/file-writer-usage" %}

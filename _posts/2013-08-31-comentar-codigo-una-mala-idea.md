---
layout: post
title: "Comentar código, una mala idea"
redirect_from:
    - /no-comentes-tu-codigo/
references:
    - {title: "Clean Code", url: "http://amzn.to/1ufbMlI"}
---

> Cada vez que escribes un comentario deberías sentir el fracaso de tu habilidad para expresarte — Robert C. Martin

La causa mas común detrás de un comentario **es un código poco expresivo y pobre**. Limpiar tu código siempre te va a llevar menos tiempo que comentar lo que hace para que se entienda.

<!--more-->

### Explícalo con código
En algunas ocasiones es difícil comunicar a través del código. Por desgracia, muchos programadores han llegado a la conclusión de que la única manera de solventarlo es comentándolo. Este hecho es completamente falso, como puedes ver ¿prefieres esto?


{% include snippet.html file="comments/bad-comments/commented-teenager" %}

¿O esto?

{% include snippet.html file="comments/bad-comments/code-teenager" %}

**Es mucho mas fácil e intuitivo expresar tu intención con código**. En la mayoría de los casos basta con crear una función con un nombre suficientemente descriptivo.

### Malos comentarios

Por lo general, todos los comentarios entran dentro de esta categoría. La mayor parte son monólogos por parte del programador hacia si mismo.

#### Ruido

{% include snippet.html file="comments/bad-comments/noise" %}

Algunas veces verás comentarios que no son otra cosa que ruido. Resaltan lo obvio y no proporcionan información útil.

#### PHPDoc en APIs no públicas

{% include snippet.html file="comments/bad-comments/phpdoc" %}

Generar PHPDoc para clases y métodos internos a un sistema no es útil, además el formato PHPDoc es engorroso y hace poco más que añadir distracción.

Además, desde [PHP 7.0](http://php.net/manual/en/functions.returning-values.php#functions.returning-values.type-declaration) y el soporte para declaración de tipos, su uso es obsoleto. La misma información se puede reescribir usando tipos

{% include snippet.html file="comments/bad-comments/types" %}

#### Código comentado

Pocas prácticas son peores que comentar código. Simplemente no lo hagas.

```php?start_inline=1
$pos = count($array);
//$pos += 1;
if ($pos > 30) {
    //$result = $pos + 2;
    $result = $pos + 3;
}
```

Algunos leerán el código y no tendrán el coraje de borrarlo - *si está ahí será por algo ¿no?* - Gracias al control de versiones puedes recuperar el código así que no tengas miedo a eliminarlo.

#### Marcas de posición

Algunas veces a los programadores nos gusta marcar ciertas posiciones del código.

```php?start_inline=1
// Utility functions ///////////
```

Muy pocas veces tiene sentido utilizarlas, especialmente los últimos caracteres. Son un tipo de ruido que normalmente se ignora.

#### Atribuciones
```php?start_inline=1
// By Manolo
```

El control de versiones ya ofrece un historial suficientemente detallado como para averiguar el autor de cada pieza de código. No es necesario indicarlo con comentarios.

#### Auto-completado en IDE
```php?start_inline=1
/** @var Domain/Entities/User */
private $user;
```

Que tu IDE preferido determine el tipo de los objetos gracias a estos comentarios no lo hace útil para el resto de tus compañeros. Hay que mantenerlos y en un futuro es muy posible que mientan y confundan sobre su propósito.

#### Registro de cambios
Antiguamente se podía tener constancia de los cambios en un sistema gracias a un registro en los comentarios y era una práctica útil.

```php?start_inline=1
/*
 * Changes (from 30-Aug-2013)
 * --------------------------
 * 30-Aug-2013 : Added a description for the footer
 * 17-Aug-2013 : Removed UserFactory
 * 05-Aug-2013 : Added Facebook login
 */
```

Hoy en día con el control de versiones ha dejado de tener sentido.

#### Anotaciones
```php?start_inline=1
/**
 * @Template("BlogBundle:Blog:home.html.twig")
 */
public function homeAction() {}
```

Debido a que son un tipo de comentario con comportamiento asociado (magia), [crean mas problemas de los que solucionan](/no-uses-anotaciones/).

### Comentarios aceptables
En casos muy concretos algunos comentarios son beneficiosos o incluso necesarios. Ten siempre presente que **el único comentario realmente útil es aquel que no escribes**.

#### Comentarios legales
```php?start_inline=1
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
```

Este tipo de comentarios *a veces* son necesarios por motivos de licencia. Generalmente los editores modernos suelen colapsarlos y es fácil ignorarlos.

#### Comentarios informativos
```php?start_inline=1
private $time = 1000; // In seconds
```

En contadas ocasiones es necesario aclarar el código, comentar justo las partes que no son suficientemente claras esta justificado.

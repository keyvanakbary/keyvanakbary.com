---
layout: post
title: "¡No comentes tu código!"
description:
    La causa mas común detrás de un comentario es un código poco expresivo y pobre. Limpiar tu código siempre te va a llevar menos tiempo que comentar lo que hace para que se entienda.
---

> Every time you write a comment, you should grimace and feel the failure of your ability of expression - Robert C. Martin

La causa mas común detrás de un comentario **es un código poco expresivo y pobre**. Limpiar tu código siempre te va a llevar menos tiempo que comentar lo que hace para que se entienda.

### Explícalo con código
En algunas ocasiones es difícil comunicar a través del código. Por desgracia, muchos programadores han llegado a la conclusión de que la única manera de solventarlo es comentándolo. Este hecho es completamente falso, como puedes ver ¿prefieres esto?
{% highlight php startinline %}
// Is a teenager
if ($user->getAge() > 12 && $user->getAge() < 20)
{% endhighlight %}
¿O esto?
{% highlight php startinline %}
if ($user->isTeenager())
{% endhighlight %}
**Es mucho mas fácil e intuitivo expresar tu intención con código**. En la mayoría de los casos basta con crear una función con un nombre suficientemente descriptivo.

### Malos comentarios
Por lo general, todos los comentarios entran dentro de esta categoría. La mayor parte son monólogos por parte del programador hacia si mismo.

#### Ruido
{% highlight php startinline %}
// The name
private $name;

// The birth date;
private $birthDate;

// Default constructor
public function __construct()
{% endhighlight %}
Algunas veces verás comentarios que no son otra cosa que ruido. Resaltan lo obvio y no proporcionan información útil.

#### PHPDoc en APIs no públicas
{% highlight php startinline %}
/**
 * Sums two numbers
 * @param int num1
 * @param int num2
 * @return int
 */
function sum($num1, $num2)
{% endhighlight %}
Generar PHPDoc para clases y métodos internos a un sistema no es útil, además el formato PHPDoc es engorroso y hace poco más que añadir distracción.

#### Código comentado
Pocas prácticas son peores que comentar código. Simplemente no lo hagas.
{% highlight php startinline %}
$pos = count($array);
//$pos += 1;
if ($pos > 30) {
    //$result = $pos + 2;
    $result = $pos + 3;
}
{% endhighlight %}
Algunos leerán el código y no tendrán el coraje de borrarlo - *si está ahí será por algo ¿no?* - Gracias al control de versiones puedes recuperar el código así que no tengas miedo a eliminarlo.

#### Marcas de posición
Algunas veces a los programadores les gusta marcar ciertas posiciones del código.
{% highlight php startinline %}
// Utility functions ///////////
{% endhighlight %}
Muy pocas veces tiene sentido utilizarlas, especialmente los últimos caracteres. Son un tipo de ruido que normalmente se ignora.

#### Atribuciones
{% highlight php startinline %}
// By Manolo
{% endhighlight %}
El control de versiones ya ofrece un historial suficientemente detallado como para averiguar el autor de cada pieza de código. No es necesario indicarlo con comentarios.

#### Auto-completado en IDE
{% highlight php startinline %}
/** @var Domain/Entities/User */
private $user;
{% endhighlight %}
Que tu IDE preferido determine el tipo de los objetos gracias a estos comentarios no lo hace útil para el resto de tus compañeros. Hay que mantenerlos y en un futuro es muy posible que mientan y confundan sobre su propósito.

#### Registro de cambios
Antiguamente se podía tener constancia de los cambios en un sistema gracias a un registro en los comentarios y era una práctica útil.
{% highlight php startinline %}
/*
 * Changes (from 30-Aug-2013)
 * --------------------------
 * 30-Aug-2013 : Added a description for the footer
 * 17-Aug-2013 : Removed UserFactory
 * 05-Aug-2013 : Added Facebook login
 */
{% endhighlight %}
Hoy en día con el control de versiones ha dejado de tener sentido.

#### Anotaciones
{% highlight php startinline %}
/**
 * @Template("BlogBundle:Blog:home.html.twig")
 */
public function homeAction() {}
{% endhighlight %}
Debido a que son un tipo de comentario con comportamiento asociado (magia), [crean mas problemas de los que solucionan](/no-uses-anotaciones/).

### Comentarios aceptables
En casos muy concretos algunos comentarios son beneficiosos o incluso necesarios. Ten siempre presente que **el único comentario realmente útil es aquel que no escribes**.

#### Comentarios legales
{% highlight php startinline %}
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
{% endhighlight %}
Este tipo de comentarios *a veces* son necesarios por motivos de licencia. Generalmente los editores modernos suelen colapsarlos y es fácil ignorarlos.

#### Comentarios informativos
{% highlight php startinline %}
private $time = 1000; // In seconds
{% endhighlight %}
En contadas ocasiones es necesario aclarar el código, comentar justo las partes que no son suficientemente claras esta justificado.

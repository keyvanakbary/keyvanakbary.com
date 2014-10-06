---
layout: post
title: "¡No uses anotaciones!"
description:
    Las anotaciones son algo mágico. La magia en el software es mala por definición, lo es porque no sabemos como funciona exactamente. Son un foco de malentendidos, provocan inesperados side effects y dependen de interpretes de terceros.
redirect_from:
    - /no-uses-anotaciones-en-php/
---

Si utilizas un [ORM](http://en.wikipedia.org/wiki/Object-relational_mapping) como [Doctrine 2](http://www.doctrine-project.org/) te habrás percatado que utilizar anotaciones para mapear entidades es una practica sorprendentemente popular:

{% highlight php startinline %}
/** @Document */
class User
{
    /** @Id */
    private $id;

    /** @Field(type="string") */
    private $name;
}
{% endhighlight %}

También el de utilizarlas como configuración en tus controladores en [Symfony 2](http://symfony.com/):

{% highlight php startinline %}
/**
 * @Route("/")
 * @Template("BlogBundle:Blog:home.html.twig")
 */
public function homeAction() {}
{% endhighlight %}

### Utilizar anotaciones es una mala idea
Las anotaciones son algo **mágico**. La magia en el software es mala por definición, lo es porque no sabemos como funciona exactamente. Son un foco de malentendidos, provocan inesperados **side effects** y dependen de interpretes de terceros.

#### Depurarlas no es sencillo
Debido a que **no son nativas del lenguaje** y funcionan de una forma poco habitual, requieren de intérpretes que normalmente bifurcan o interrumpen el flujo natural de tu código para ejecutarlas. Seguir la ejecución es cuanto menos una odisea.

#### Contaminan tu dominio
La capa de dominio debe ser agnóstica a los detalles. Así pues, persistir o no tus entidades de dominio sobre una base de datos o mantenerlas en memoria es un detalle de infraestructura en que el dominio no es partícipe. Incrustar anotaciones (configuración) en tu dominio **es de las peores aberraciones que puedes cometer**, hacen que tu dominio sea **frágil y rígido** y no permiten una clara separación en capas.

#### Dificultan la lectura
No nos olvidemos, las anotaciones son comentarios y si estos ya de por si son una fuente de problemas, el hecho de que ejecuten cosas debería hacer saltar todas las alarmas. Las anotaciones se mezclan con tu código, entorpeciendo su lectura y convirtiéndolo en un popurrí indescifrable.

### Alternativas
Dado que detrás de las anotaciones, en algún lugar recóndito, hay código respaldándolas, **siempre va a haber una forma de evitarlas**.

Por ejemplo, en **Symfony 2** liberar a tu controlador de la configuración de enrutado es tan sencillo como crear un fichero YAML:

{% highlight yaml %}
home:
    pattern: /
    defaults: { _controller: Bundle:Controller:home }
{% endhighlight %}

De la misma forma, **Doctrine 2** permite separar tu dominio de los detalles de persistencia a través de ficheros de mapeo:

{% highlight yaml %}
Documents\User:
    db: documents
    collection: user
    fields:
        id:
            id: true
        name:
            type: string
{% endhighlight %}

¡Mucho mas claro! A la larga te aseguro que lo agradecerás.

---
layout: post
title: "¡No uses anotaciones en PHP!"
description:
    Las anotaciones son magia arcana, y la magia en el software es mala por naturaleza, lo es porque no sabemos como funciona exactamente. Es un agujero de conocimiento ideado por algún chaman de las cavernas.
---

Si utilizas un [ORM](http://en.wikipedia.org/wiki/Object-relational_mapping) como [Doctrine 2](http://www.doctrine-project.org/) te habrás percatado que utilizar anotaciones para mapear entidades es una practica sorprendentemente popular:

{% highlight php %}
<?php

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

{% highlight php %}
<?php

/**
 * @Route("/")
 * @Template("BlogBundle:Blog:home.html.twig")
 */
public function homeAction() {}
{% endhighlight %}

### ¿Y porqué no?
Las anotaciones son **magia arcana**, y la magia en el software es mala por naturaleza, lo es porque no sabemos como funciona exactamente. Es un agujero de conocimiento ideado por algún **chaman de las cavernas**.

#### 1. No puedes testearlas
El código de una anotación no está vinculado con tu lógica. Cuando vayas a testear su comportamiento lo vas a pasar mal.

#### 2. No puedes depurarlas
Precisamente como no es tu código ocurre que cuando tengas un problema vas a tener que estudiar los entresijos de tamaño milagro ingenieril para llegar al verdadero problema.

#### 3. No permiten una clara separación en capas
A menudo se utilizan como configuración, mezclando las capas mas abstractas como el dominio con las mas concretas como la infraestructura haciendo que el código sea muy **frágil y rígido**. Hacerlo debería apestarte tanto como incrustar bloques de configuración XML en medio de tu lógica de negocio.

#### 4. Dependes de la lógica de un tercero
Tu lógica depende una librería que sepa interpretar dichas anotaciones. No te va a ser fácil modificar su comportamiento estándar o prescindir de sus servicios.

#### 5. Dificultan la lectura
Las anotaciones se mezclan con tu código, entorpeciendo su lectura y convirtiéndolo en un popurrí indescifrable.

### Alternativas
Dado que detrás de las anotaciones, en alguna cueva recóndita y oscura hay código, **siempre va a haber una forma de evitarlas**.

Por ejemplo, enrutar tus controladores con **Symfony 2** es tan sencillo como crear un fichero YAML con la configuración:

    home:
        pattern: /
        defaults: { _controller: Bundle:Controller:home }

De la misma forma, en **Doctrine 2** puedes separar la lógica de tus entidades de la información de mapeo:

    Documents\User:
        db: documents
        collection: user
        fields:
            id:
                id: true
            name:
                type: string

¡Mucho mas claro! A la larga te aseguro que lo agradecerás.
---
layout: post
title: "Principio de responsabilidad única"
---

El principio de responsabilidad única es el primer principio del acrónimo [SOLID](http://wikipedia.com/SOLID) para la programación Orientada a Objetos.

> Un módulo o una función debe tener una y solo una responsabilidad, o lo que es lo mismo, debe tener una y solo una razón para cambiar.

<!--more-->

Más de una responsabilidad hace que el código sea dificil de leer, de testear y mantener. Es decir, hace que el código sea menos flexible, más rígido.

### ¿Y qué es una responsabilidad?
Se trata de la audiencia de un determinado módulo o función, actores que reclaman cambios al software. Las responsabilidades son básicamente familias de funciones que cumplen las necesidades de dichos actores.

En el siguiente ejemplo podemos identificar hasta 3 responsabilidades diferentes
{% highlight php startinline %}
class Employee
{
    public function calculatePay() { … } //Policy
    public function save() { … } //Architecture
    public function describeEmployee() { … } //Operations
}
{% endhighlight %}

1. Política de cálculos de salario
2. Lógica de persitencia en la base de datos
3. Cómputo de horas de trabajo

Cuando alguno de los roles involucrados en dichas responsabilidades decida cambiar o agregar funcionalidad, va a tener que cambiar dicha clase. Aumentando la probabilidad de colisión, complejidad y posibles bugs.

### Los dos valores del software
El valor secundario del software, aquel que tendemos a pensar que és el más importante, **es el de comportamiento**. Si el software se comporta como debería y no posee bugs este valor se mantiene alto.

Por desgracia, las necesidades cambian y los usuarios también, es por eso que el primer valor del software es la **facilidad al cambio**. Es más importante permitir que el software sea lo suficientemente flexible como para poder adaptarse a nuevos usuarios y necesidades que satisifacerlas en un momento concreto. Sin este valor, el secundario es dificil de acometer a largo plazo.

El principio de reponsabilidad única permite que nuestro código sea más flexible al cambio y por tanto nos ayuda a mantener el primer valor del software, el de la **facilidad al cambio**, alto.

#### Referencias
- [Clean Code](http://www.amazon.com/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882)
- [Agile Software Development](http://www.amazon.com/Software-Development-Principles-Patterns-Practices/dp/0135974445)
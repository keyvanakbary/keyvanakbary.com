---
layout: post
title: "Patrón Composite"
references:
    - {title: "Gang of Four", url: "http://amzn.to/2pT7iYB"}
    - {title: "TDD by Example", url: "http://amzn.to/2ozAouX"}
---

El patrón _Composite_ es otro de los ya clásicos patrones de diseño presentados en el libro [Gang of Four](http://amzn.to/1vIk2QL). **Nos permite agrupar el comportamiento de colecciones de objetos en objetos individuales**.

<!--more-->

> El patrón _Composite_ permite componer objetos en estructuras árbol como medio para representar jerarquías parcialmente enteras. Facilita tratar con colecciones de objetos u objetos individuales de forma uniforme.

Sin contexto la definición queda difusa. Seguramente mejor presentarlo con un ejemplo práctico.

Imaginemos por un momento que somos responsables de diseñar un sencillo sistema bancario cuyo propósito es el de llevar las cuentas de transacciones monetarias.

Podemos representar una transacción como un valor, haciendo uso del patrón [Value Object](https://en.wikipedia.org/wiki/Value_object)

{% include snippet.html file="design-patterns/composite/step0/transaction" %}

Hacemos a la cuenta bancaria responsable de agrupar, enlazar y calcular el balance de las transacciones

{% include snippet.html file="design-patterns/composite/step0/account" %}

{% include snippet.html file="design-patterns/composite/step0/account-usage" %}

En el mundo real, es común que **una persona tenga múltiples cuentas bancarias asociadas**. Si quisieramos ofrecer el balance entre todas ellas, podríamos hacerlo introduciendo el concepto de cuenta general.

{% include snippet.html file="design-patterns/composite/step0/overall-account" %}

{% include snippet.html file="design-patterns/composite/step0/overall-account-usage" %}

Echando un vistazo rápido al código te habrás percatado que, salvando algunas diferencias, **la lógica de cálculo y enlazado de transacciones y cuentas es prácticamente la misma en los objetos de `Account` y `OverallAccount`.** Ambos objetos son prácticamente idénticos y esto huele a duplicidad.

## Eliminando duplicidad

Si la lógica para enlazar y calcular el balance de transacciones en cuentas a nivel individual es similar que al de grupos de cuentas, es posible eliminar la duplicidad haciendo uso del patrón _Composite_.

Definiendo un contrato común que represente un valor, del cual se pueda deducir un balance

{% include snippet.html file="design-patterns/composite/step1/holding" %}

e implementando dicho contrato tanto en cuentas como transacciones

{% include snippet.html file="design-patterns/composite/step1/account" %}

{% include snippet.html file="design-patterns/composite/step1/transaction" %}

ahora las cuentas puedan operar tanto con transacciones como con otras cuentas, haciendo posible estructuras recursivas. El objeto `OverallAccount` ya no es necesario y puede ser eliminado.

Aplicar _Composite_ no solo elimina duplicidad, sino que también consigue librar al cliente de diferenciar entre cuentas individuales o colecciones de cuentas, unificando el comportamiento de ambos casos al provisto por `Holding`. Donde antes el código cliente esperaba un objeto individual ahora puede aceptar un compuesto.

{% include snippet.html file="design-patterns/composite/step1/holding-usage" %}

---

El paso a _Composite_ es habitual en ciclos de _refactoring_ como técnica para reducir duplicidad.

Conviene resaltar que **aplicar el patrón _Composite_ es un truco del programador**, generalmente no apreciado como abstracción del mundo real. Sin embargo **el beneficio de aplicarlo, en términos de reducción de complejidad y duplicidad en el código, es enorme** y por lo general merece la pena.

Directorios que contienen directorios, suits tests que albergan suits tests, dibujos que agrupan dibujos; ninguno de estos casos tiene sentido en plano real pero todos ellos hacen el código mucho más sencillo.

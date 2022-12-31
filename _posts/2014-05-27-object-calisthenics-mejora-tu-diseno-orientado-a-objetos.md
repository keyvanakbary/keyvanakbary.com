---
layout: post
title: "Object Calisthenics, mejora tu diseño orientado a objetos"
references:
    - {title: "Object Calisthenics First Thoughts", url: "http://www.markhneedham.com/blog/2008/11/06/object-calisthenics-first-thoughts/"}
    - {title: "Object Calisthenics RTF", url: "http://www.xpteam.com/jeff/writings/objectcalisthenics.rtf"}
---

Los conceptos que definen un buen diseño software son bien conocidos. Básicamente hay 7 propiedades que distinguen la calidad del software: **alta cohesión**, **bajo acoplamiento**, **no redundacia**, **encapsulación**, **testabilidad**, **legibilidad** y **foco**. El problema viene cuando tratas de ponerlo en práctica. Una cosa es saber que has de encapsular los datos, la implementación, el tipo, el diseño o la construcción y otra bien distinta es cómo hacerlo.

<!--more-->

# El reto
Un ejercicio que te puede ayudar a interiorizar los principios de un buen diseño orientado a objetos en el *mundo real™* es seguir al pie de la letra las siguientes reglas:

1. Un nivel de indentación por método
2. No uses la palabra clave ELSE
3. Envuelve primitivos
4. Colecciones como clases de primer orden
5. Aplica la Ley de Demeter
6. No abrevies
7. Mantén las entidades pequeñas
8. Evita más de dos atributos de instancia
9. Evita getters/setters o atributos públicos
10. Clases con estado, evita métodos estáticos

## Un nivel de indentación por método
¿Alguna vez te has quedado petrificado escudriñando a un método prehistórico preguntándote por donde demonios empezar? Un método gigante carece de cohesión. Una buena guía puede ser **limitar el tamaño de los métodos a 5 líneas**. Esto puede ser especialmente difícil si en tu código hay algún monstruo de 500 líneas. Si tienes estructuras de control anidadas es muy posible que estés trabajando a múltiples niveles de abstracción y probablemente haciendo más de una cosa.

Una vez que empieces a trabajar con métodos que hagan una sola cosa tu código empezará a cambiar. Como cada pieza será más pequeña, será más fácil reutilizar el código y lo harás cada vez más. Es difícil encontrar oportunidades para reutilizar código en un método de 100 líneas. Un método que maneja el estado de un único objeto en un contexto determinado es útil también en diferentes contextos.

Extrae métodos con tu IDE favorito de modo que tengan un único nivel de abstracción:

```php?start_inline=1
class Board {
    public function __construct() {
        $result = '';
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $i++) {
                $result .= $this->data[$i][$j];
            }
            $result .= "\n";
        }

        return $result;
    }
}
```

```php?start_inline=1
class Board {
    public function __construct() {
        return $this->collectRows();
    }

    private function collectRows() {
        $rows = '';

        for ($rowNum = 0; $rowNum < 10; $rowNum++)
            $rows .= $this->collectRow($rowNum);

        return $rows;
    }

    private function collectRow($rowNum) {
        $row = '';

        for ($j = 0; $j < 10; $i++)
            $row .= $this->data[$rowNum][$j];

        return $row . "\n";
    }
}
```

Tenemos más código si, pero un efecto positivo al refactorizarlo es que ahora cada nombre de método casa perfectamente con su implementación. Encontrar bugs en estos pequeños métodos es mucho más sencillo.

## No uses la palabra clave ELSE
Todo programador conoce de sobra la construcción if/else. Viene definido en casi cualquier lenguaje de programación, es lo suficientemente simple como para que todo el mundo lo entienda. Todos nos hemos perdido alguna vez en alguno imposible de seguir o donde cada caso se extiende hasta el infinito. Es tan sencillo añadir un caso más en vez de mejorar el diseño... Los condicionales son una fuente frecuente de duplicidad. Los flags y el estado son dos ejemplos que llevan a este tipo de problemas

```php?start_inline=1
if ($type === 'engineer') {
    return 300;
} else {
    return 200;
}
```

Los lenguajes Orientado a Objetos ofrecen una poderosa herramienta para manejar casos complejos, **el polimorfismo**. Los diseños que hacen uso del polimorfismo son más fáciles de leer y mantener, expresan su intención de una manera más clara.

```php?start_inline=1
class Employee {
    public abstract function salary();
}

class Engineer extends Employee {
    public function salary() {
        return 300;
    }
}

class StateAgent extends Employee {
    public function salary() {
        return 200;
    }
}
```

Como parte del ejercicio prueba a utilizar el patrón [Null Object](http://en.wikipedia.org/wiki/Null_Object_pattern), puede que te ayude en algunas situaciones. Hay otros métodos para liberarte del ELSE, intenta buscar alternativas.

## Envuelve los primitivos
En PHP, los `int` no son objetos, obedecen otro tipo de reglas. Se utilizan con sintaxis no orientada a objetos. Más importante aún, un `int` es un escalar así que no tiene significado por sí solo. Cuando un método recibe un entero como argumento, es el método el que tiene que hacer el trabajo duro para revelar su intención. Si el mismo método recibe una `Hour` como parámetro, es mucho más sencillo averiguar que está pasando. Objetos pequeños como este hacen el programa más mantenible, especialmente desde el momento en el que no puedes pasar un `Year` a un método que necesita un `Hour`. Con un primitivo variable, el intérprete no puede ayudarte a escribir programas sintácticamente correctos. Con un objeto, incluso con uno pequeño, estas dando información adicional tanto al programador como al intérprete sobre su propósito.

Pequeños objetos como `Hour` o `Money` también nos ofrecen un lugar donde añadir comportamiento que de otra forma estaría en otras clases.

## Colecciones como clases de primer orden
La regla es sencilla, cualquier clase que contenga una colección no debería contener más atributos. Cada colección se envuelve en su propia clase, de esta forma los comportamientos relacionados con la colección tienen un lugar. Probablemente los filtros formen parte de esta nueva clase. También, tu nueva clase puede manejar peticiones como juntar dos grupos o aplicar una regla para cada elemento del grupo.

## Aplica la Ley de Demeter
A veces es difícil saber que objeto debe tener la responsabilidad para una determinada acción. Si empiezas a buscar por las líneas con múltiples `->`, empezarás a encontrar responsabilidades fuera de lugar. Si tienes más de un `->` en una línea de código significa que la acción está ocurriendo en el lugar equivocado. Puede que tu objeto esté lidiando con dos objetos a la vez. Si es este el caso, tu objeto es un intermediario, sabe demasiado sobre demasiada gente. Considera el mover esa acción a alguno de los otros objetos.

Si todos esos `->` están conectados es probable que tu objeto esta profundizando demasiado en otro. Todos ellos indican que estás violando la encapsulación. Prueba a preguntar que haga algo por ti en vez de investigar dentro de él. Una gran parte de la encapsulación trata de no cruzar el límite de una clase como para saber sobre sus tipos internos.

La [Ley de Demeter](http://en.wikipedia.org/wiki/Law_of_Demeter) (“Habla solo con tus amigos”) es un buen comienzo. Piensa en ello de la siguiente forma: Puedes jugar con tus juguetes, juguetes que tú haces o juguetes que alguien te dá. Nunca jamás juegues con los juguetes de tus juguetes.

```php?start_inline=1
class Piece {
    public $representation;
}

class Location {
    public $currentPiece;
}

class Board {
    public function boardRepresentation() {
        $representation = '';

        foreach ($this->squares() as $location) {
            $representation .= $location->currentPiece->representation[0];
        }

        return $representation;
    }
}
```

Podemos refactorizarlo a

```php?start_inline=1
class Piece {
    private $representation;

    private function character() {
        return $this->representation[0];
    }

    public function addTo($str) {
        return $str . $this->character();
    }
}

class Location {
    public $currentPiece;

    public function addTo($str) {
        return $this->currentPiece->addTo($str);
    }
}

class Board {
    public function boardRepresentation() {
        $representation = '';

        foreach ($this->squares() as $location) {
            $representation = $location->addTo($representation);
        }

        return $representation;
    }
}
```

Fíjate que en este ejemplo la implementación del algoritmo es más difusa, es posible que entenderlo como un todo sea más difícil, sin embargo, has creado un método que revela que una parte de la transformación consiste en extraer un carácter. Es un método con un nombre absolutamente cohesivo, es muy probable que se pueda reutilizar. Las enigmática parte `$representation[0]` se ha visto encapsulada y reducida a un método que revela su intención.

## No abrevies
Es una tentación abreviar nombres de clases, métodos o variables. Resiste, **las abreviaciones confunden y tienden a ocultar problemas más serios**.

Piensa en el porqué abrevias. ¿Es porque repites la misma palabra una y otra vez? Si es ese caso quizás tu constructor se usa demasiadas veces y estas perdiendo oportunidades de reutilizar el código. ¿Es porque tus nombres cada vez son más largos? Esto puede ser un signo de responsabilidad mal ubicada o una clase ausente.

Intenta hacer que tus métodos sean de 1 o 2 palabras. **Evita los nombres que dupliquen el contexto**. Si la clase es `Order`, el método no necesita llamarse `shipOrder()`. Simplemente llama al método `ship()` de forma que los clientes vean `$order->ship()` una representación simple y clara de lo que está pasando.

## Manten las entidades pequeñas
Trata de no superar las 50 líneas por clase y los 10 ficheros por paquete.

Las clases con más de 50 líneas por lo general hacen más de una cosa, lo que las convierte en algo más difícil de comprender y reutilizar. 50 líneas tienen un beneficio añadido, puedes determinar que hacen de un solo vistazo sin tener que hacer scroll.

La dificultad en crear clases tan pequeñas es que a menudo los comportamientos solo tienen sentido juntos. Es aquí donde entran en juego los paquetes. Como hemos limitado también el número de ficheros en un paquete comenzarás a verlos como pequeños grupos de clases relacionadas con un objetivo común. Los paquetes, como las clases, deberían ser cohesivos en su propósito. Hacer los paquetes pequeños les hace tener identidad propia.

## Evita más de dos atributos de instancia
La mayoría de las clases deberían ser responsables únicamente del manejo de una única variable de instancia, algunas requerirán de dos. Añadir una nueva variable de instancia a una clase, reduce de forma inmediata la cohesión de la clase. Programando de esta forma encontrarás que hay dos tipos de clases, aquellas que mantienen el estado de una única variable de instancia y aquellas que coordinan dos variables separadas. En general, no mezcles los dos tipos de responsabilidades.

```php?start_inline=1
class Name {
    private $first;
    private $middle;
    private $last;
}
```

Se puede descomponer en

```php?start_inline=1
class Name {
    private $surname;
    private $given;
}

class Surname {
    private $family;
}

class GivenNames {
    private $names = [];
}
```

Si piensas en como descomponer, la oportunidad para separar el cometido de un nombre de familia (usado para restricciones de entidad) puede ser separado y reutilizado para otro tipo de nombres. El objeto `GivenName` contiene una lista de nombres, permitiendo al nuevo modelo absorber personas con nombres como `first`, `middle` y otros. La descomposición de variables de instancia te ayuda a entender lo que tienen en común algunas de ellas.

La experiencia descomponiendo atributos en una jerarquía de objetos que colaboran entre ellos lleva a un modelo efectivo y directo. Sin entender esta regla solemos perdernos entre las relaciones y flujos de grandes objetos. En contraste, la aplicación recursiva de esta regla nos lleva a una descomposición rápida de objetos complejos y grandes en modelos mucho más sencillos. El *comportamiento* conduce a las variables de instancia al lugar adecuado.

## Evita getters/setters o atributos públicos
Si tus objetos no encapsulan apropiadamente el conjunto de variables de instancia y el diseño se vuelve engorroso, es el momento perfecto para examinar violaciones en la encapsulación. El comportamiento no seguirá las variables de instancia si puede preguntar por su valor en su lugar actual. La idea detrás de unas fuertes fronteras en los límites de la encapsulación es que fuerza a los programadores a trabajar con el código que has preparado. El acceso al comportamiento esta limitado a un único lugar. Esto desencadena muchos efectos, como por ejemplo una reducción dramática en la duplicidad de código, errores y una mejor localización de los cambios para implementar nuevas funcionalidades.

```php?start_inline=1
class Account {
    private $money = 0;

    public function getMoney() {
        return $this->money;
    }

    public function setMoney($money) {
        $this->money = $money;
    }
}

//Add money to account
$newMoney = $account->getMoney() + 100;
$account->setMoney($newMoney);
```
En este ejemplo, la clase `Account` es básicamente una estructura de datos sin comportamiento alguno. Una clase anémica que favorece la proliferación de *transaction scripts* a su alrededor para operar con ella.

Un mejor diseño podría ser

```php?start_inline=1
class Account {
    private $money = 0;

    public function addMoney($amount) {
        $this->money += $amount;
    }
}

$account->addMoney(100);
```

Una forma popular de llamar a esta regla es "[Tell, don't ask](http://martinfowler.com/bliki/TellDontAsk.html)".

## Clases con estado, evita métodos estáticos
Esta regla es quizás la más difícil de transmitir, tampoco es tan clara de visualizar como las anteriores. Las llamadas "utility classes" que simplemente operan otros objetos no tienen identidad, no tienen razón de existencia. Preguntan a los objetos por sus datos y los manipulan en favor de otros. En general, son una gran fuente de violación de encapsulación.

# Conclusión
8 de estas 10 reglas son simples guías de cómo visualizar e implementar el santo grial de la programación orientada a objetos, **la encapsulación de los datos**. Como plus, otra nos ayuda con el entendimiento del polimorfismo y otra deja claro estrategias de nombrado que fuerzan mejores nombres. La idea general es la librar al código de duplicidad. Código que expresa de forma concisa abstracciones simples y elegantes para la complejidad accidental con la que lidiamos día a día.

A largo plazo, encontrarás que estas sencillas reglas se contradicen unas a otras en algunas situaciones o que la aplicación estricta de las reglas perjudican el código. Bienvenido a la ingeniería, no hay balas de plata, todo se trata de analizar los tradeoffs. De todas formas, te recomiendo que experimentes con ellas. Emplea 20 horas y 1000 líneas de código siguiendo estas reglas de forma estricta. A lo mejor te descubres rompiendo viejos hábitos y cambiando reglas con las que has convivido a lo largo de toda tu carrera profesional...

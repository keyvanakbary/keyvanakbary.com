---
layout: post
title: "Test doubles"
---

De forma análoga al uso de dobles en Hollywood, los *test doubles* son un término genérico que hace referencia a cualquier caso en el que se reemplaza un objeto de producción con otro con el único objetivo de probar el código.

<!--more-->

Imaginemos que queremos probar una parte nuestro sistema que depende de la siguiente interfaz

{% highlight php startinline %}
interface Authorizer {
    /**
     * @return boolean
     */
    public function authorize($username, $password);
}
{% endhighlight %}

Dependiendo del contexto y la intención del test disponemos de una buena variedad de *dobles* para satisfacer dicha dependencia.

## Dummy
{% highlight php startinline %}
class DummyAuthorizer implements Authorizer {
    public function authorize($username, $password) {
    }
}
{% endhighlight %}

Un objeto `Dummy` es algo que **se utiliza para satisfacer dependencias, su uso en ejecución es completamente irrelevante**.

{% highlight php startinline %}
class System {
    private $authorizer;
    
    public function __construct(Authorizer $authorizer) {
        $this->authorizer = $authorizer;
    }
    
    public function loginCount() {
        //returns number of logged in users
    }
}
{% endhighlight %}

{% highlight php startinline %}
/**
 * @test
 */
public function newlyCreatedSystemHasNoLoggedInUsers() {
    $system = new System(new DummyAuthorizer());
    $this->assertThat($system->loginCount(), $this->equalsTo(0));
}
{% endhighlight %}

Aunque en este test en concreto no se haga uso explícito de `Authorizer`, es necesario satisfacer la dependencia para poder construir `System`. El método `authorize` no se ejecutará dado que en este test nadie va a iniciar sesión. Por eso no es un problema que dicho método no devuelva nada. Si alguien lo utiliza, la ejecución se romperá y eso es lo que queremos, **un `Dummy` no debería usarse en ejecución**.

## Stub
Imaginemos que ahora queremos probar una parte del sistema que requiere de haber iniciado sesión. No queremos utilizar la lógica de un autentificador real, nuestro propósito es probar únicamente la parte del sistema que utiliza el login, no el propio login. Hacerlo incrementaría el acoplamiento con el código y por tanto aumentaría la fragilidad de nuestro sistema. Un fallo en el login rompería el test aunque no hubiese cambiado la lógica de negocio. Además en muchos casos, las dependencias son complejas y no queremos depender de setups largos y lentos.

{% highlight php startinline %}
class AcceptingAuthorizerStub implements Authorizer {
    public function authorize($username, $password) {
        return true;
    }
}
{% endhighlight %}

El propósito de un `Stub` es el de **proveer valores concretos para guiar al test en una determinada dirección**.

De la misma forma, si queremos probar una parte del sistema a cargo de usuarios no autorizados podemos hacer que el `Stub` devuelva `false`.


## Spy
Cuando quieras asegurarte de haber llamado a un método en tu sistema puedes utilizar un espía.

{% highlight php startinline %}
class AcceptingAuthorizerSpy implements Authorizer {
    public $authorizeWasCalled = false;

    public function authorize($username, $password) {
        $this->authorizeWasCalled = true;
        return true;
    }
}
{% endhighlight %}

Comprobarlo es tan sencillo como preguntar a nuestro espía si se ha llamado al método en cuestión en la fase de aserción de nuestro test.

Hay que tener cuidado, **espiar al que te llama tiene un coste y se paga en forma de acoplamiento**. Cuanto más espías, más te acoplas a la implementación y más frágiles serán tus tests.

## Mock
{% highlight php startinline %}
class AcceptingAuthorizerVerificationMock implements Authorizer {
    public $authorizeWasCalled = false;

    public function authorize($username, $password) {
        $this->authorizeWasCalled = true;
        return true;
    }

    public function verify() {
        return $this->authorizeWasCalled;
    }
}
{% endhighlight %}

Un mock conoce lo que se se está testeando. Si te fijas, se ha movido la fase de verificación del test al mock. Al contrario que un `Stub`, un `Mock` no está tan interesado en devolver valores concretos. Un mock esta más interesado en que métodos se han invocado, con que argumentos, cuando y con que frecuencia. Un mock siempre es un espía.

## Fake
{% highlight php startinline %}
class AcceptingAuthorizerFake implements Authorizer {
    public function authorize($username, $password) {
        return $username === 'Bob';
    }
}
{% endhighlight %}

Únicamente los usuarios con nombre de usuario “Bob” serán autorizados. Puedes hacer que un `Fake` se comporte de forma diferente según los datos que envíes. **Es una especie de simulador**.

Un `Fake` no es un `Stub` dado que los `Stubs` no tienen lógica de negocio en ellos. Podríamos decir que en cierta manera un `Mock` es un espía, un espía es un tipo de `Stub` y un `Stub` es algo parecido a un `Dummy`. Un `Fake` no se parece a ninguno de ellos. Un `Fake` contiene cierto tipo lógica y puede complicarse hasta el punto de llegar a necesitar tests.

Un ejemplo típico de `Fake` son las [InMemoryTestDatabase](http://www.martinfowler.com/bliki/InMemoryTestDatabase.html).

## Librerías de Mocks
Los `Dummies`, `Stubs` y espías son sencillos de escribir, especialmente si cuentas con un IDE moderno. Por otro lado, escribir `Mocks` no lo es tanto. Librerías como [PHPUnit](http://phpunit.de/manual/3.0/en/mock-objects.html) o [Mockery](https://github.com/padraic/mockery) diluyen esta dificultad en un mar de adictivas DSLs. La facilidad con la que puedes escribir `Mocks` con ellas es un arma de doble filo que te puede hacer perder la visión del precio de añadirlos.

Añadir más aserciones o espiar en la llamada tiene un coste mas elevado que el de la propia implementación, comunmente lo denominamos acoplamiento. Cada uno de los *test doubles* tiene un propósito y un contexto, a más detalle, mayor coste, mayor fragilidad.


#### Referencias

- [The Little Mocker](http://blog.8thlight.com/uncle-bob/2014/05/14/TheLittleMocker.html)
- [Mocks Aren't Stubs](http://martinfowler.com/articles/mocksArentStubs.html)
- [Test Doubles](http://www.martinfowler.com/bliki/TestDouble.html)
- [xUnit Test Patterns](http://amzn.to/1FYC4iI)
- [GOOS](http://amzn.to/1u3YVTh)
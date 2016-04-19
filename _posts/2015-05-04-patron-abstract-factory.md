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

```php?start_inline=1
class HelloWorldFileWriter {
    public function writeTo($filepath) {
        $file = new SplFileObject($filepath, 'w+');
        $file->fwrite('Hello World!');
    }
}

$writer = new HelloWorldFileWriter();
$writer->writeTo('file.txt');
```

Tiene un pequeño inconveniente, este código no se puede testear de forma unitaria, esto es, sin tener que crear un fichero realmente. El servicio esta acoplado directamente a la creación de `SplFileObject`.

Podemos extraer la lógica de creación haciendo uso del patrón [Factory](/patron-factory/)

```php?start_inline=1
class FileFactory {
    public function createFile($filename, $openMode) {
        return new SplFileObject($filename, $openMode);
    }
}

class HelloWorldFileWriter {
    private $fileFactory;

    public function __construct(FileFactory $fileFactory) {
        $this->fileFactory = $fileFactory;
    }

    public function writeTo($filepath) {
        $file = $this->fileFactory->createFile($filepath, 'w+');
        $file->fwrite('Hello World!');
    }
}

$writer = new HelloWorldFileWriter(new FileFactory());
$writer->writeTo('file.txt');
```

Haciendo uso de [Duck Typing](http://en.wikipedia.org/wiki/Duck_typing) y [Mockery](https://github.com/padraic/mockery) podemos reemplazar la abstracción `SplFileObject` por un [Test Double](/test-doubles/) espía en nuestros tests

```php?start_inline=1
class HelloWorldFileWriterTest extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function itShouldWriteHelloWorld() {
        $writer = new HelloWorldFileWriter(
            $this->createFileFactoryStubWith(
                $file = new FileSpy()
            )
        );

        $writer->writeTo('irrelevant-file.txt');

        $this->assertEquals('Hello World!', $file->data);
    }

    private function createFileFactoryStubWith($file) {
        $stub = Mockery::mock('FileFactory');
        $stub->shouldReceive('createFile')->andReturn($file);

        return $file;
    }
}

class FileSpy {
    public $data;

    public function fwrite($data) {
        $this->data = $data;
    }
}
```

## Multiples Implementaciones
Ahora bien, la abstracción `SplFileObject` [no se introdujo hasta la versión de PHP 5.1.0](http://php.net/manual/en/class.splfileobject.php). Como ejemplo ilustrativo, imaginemos que algunos de nuestros clientes siguen utilizando la versión de PHP 5.0.0. Podemos crear una nueva implementación para la abstracción del sistema de ficheros basada en los clásicos descriptores de fichero para ellos.

El primer paso es definir una interfaz común para la abstracción del sistema de ficheros con la que exponer un contrato claro e independiente al de `SplFileObject` sobre el cual tengamos control total

```php?start_inline=1
interface File {
    public function write($data);
}
```

Encapsulamos la actual implementación de `SplFileObject` destinada a clientes con una versión de PHP mayor a la 5.1.0

```php?start_inline=1
class SplFile implements File {
    private $file;

    public function __construct($filename, $openMode) {
        $this->file = new SplFileObject($filename, $openMode);
    }

    public function write($data) {
        $this->file->fwrite($data);
    }
}
```

Y definimos una nueva implementación basada en descriptores para los clientes con PHP menor a la 5.1.0

```php?start_inline=1
class DescriptorFile implements File {
    private $fd;

    public function __construct($filename, $openMode) {
        $this->fd = fopen($filename, $openMode);
    }

    public function write($data) {
        fwrite($this->fd, $data);
    }

    public function __destruct() {
        fclose($this->fd);
    }
}
```

De la misma forma, podemos crear dos provedores de abstracciones de ficheros. Esto es, podemos crear un **Abstract Factory** con múltiples implementaciones

```php?start_inline=1
interface FileFactory {
    public function createFile($filename, $openMode);
}

class DescriptorFileFactory implements FileFactory {
    public function createFile($filename, $openMode) {
        return new DescriptorFile($filename, $openMode);
    }
}

class SplFileFactory implements FileFactory {
    public function createFile($filename, $openMode) {
        return new SplFile($filename, $openMode);
    }
}
```

Solo es necesario adaptar nuestro código a la nueva interfaz en el servicio `HelloWorldFileWriter`

```php?start_inline=1
    $file->write('Hello World!');
```

Y en los tests

```php?start_inline=1
class FileSpy implements File {
    public $data;

    public function write($data) {
        $this->data = $data;
    }
}
```

Ahora es el cliente el que puede elegir que **Factory** utilizar según su versión de PHP sin que ello afecte en absoluto a la ejecución de nuestro servicio

```php?start_inline=1
// Bootstrap
$writer = new HelloWorldFileWriter(
    new SplFileFactory()           // PHP > 5.1.0
    // new DescriptorFileFactory() // PHP < 5.1.0
);

// Application
$writer->writeTo('file.txt');
```

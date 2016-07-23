<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午5:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

use FastD\Generator\Factory\GetSetter;
use FastD\Generator\Factory\Method;
use FastD\Generator\Factory\Obj;
use FastD\Generator\Factory\Param;
use FastD\Generator\Factory\Property;

class GenerateTest extends \PHPUnit_Framework_TestCase
{
    public function testProperty()
    {
        $name = new Property('name');

        $this->assertEquals($name->generate(), <<<M
    /**
     * @var mixed
     */
    protected \$name;
M
        );

        $name = new Property('name', Property::PROPERTY_ACCESS_PRIVATE);

        $this->assertEquals($name->generate(), <<<M
    /**
     * @var mixed
     */
    private \$name;
M
        );

        $name = new Property('name', Property::PROPERTY_ACCESS_PROTECTED, 'string');

        $this->assertEquals($name->generate(), <<<M
    /**
     * @var string
     */
    protected \$name;
M
        );

        $name = new Property('name', Property::PROPERTY_CONST, 'string');

        $this->assertEquals($name->generate(), <<<M
    /**
     * @const string
     */
    const NAME = null;
M
        );

        $name = new Property('name', Property::PROPERTY_ACCESS_PROTECTED, 'string');

        $name->setStatic();

        $this->assertEquals($name->generate(), <<<M
    /**
     * @var string
     */
    protected static \$name;
M
        );

        $name = new Property('name', Property::PROPERTY_ACCESS_PROTECTED, 'string');

        $name->setValue('\Test::NAME');

        $this->assertEquals(<<<M
    /**
     * @var string
     */
    protected \$name = \Test::NAME;
M
            , $name->generate());
    }

    public function testMethod()
    {
        $method = new Method('name');

        $this->assertEquals($method->generate(), <<<M
    public function name()
    {
        // TODO...
    }
M
);

        $method = new Method('name', Method::METHOD_ACCESS_PROTECTED);

        $this->assertEquals($method->generate(), <<<M
    protected function name()
    {
        // TODO...
    }
M
        );

        $method = new Method('name', Method::METHOD_ACCESS_PRIVATE);

        $this->assertEquals($method->generate(), <<<M
    private function name()
    {
        // TODO...
    }
M
        );

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_STATIC);

        $this->assertEquals($method->generate(), <<<M
    public static function name()
    {
        // TODO...
    }
M
        );

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_ABSTRACT);

        $this->assertEquals($method->generate(), <<<M
    abstract public function name();
M
        );

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_INTERFACE);

        $this->assertEquals($method->generate(), <<<M
    public function name();
M
        );

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_INTERFACE);

        $method->setParams([
            new Param('name'),
            new Param('test', 'Test', null),
        ]);

        $this->assertEquals($method->generate(), <<<M
    public function name(\$name, \Test \$test = null);
M
        );

        $method = new Method('name');

        $method->setParams([
            new Param('name'),
            new Param('test', 'Test', null),
        ]);

        $this->assertEquals($method->generate(), <<<M
    public function name(\$name, \Test \$test = null)
    {
        // TODO...
    }
M
        );

        $method = new Method('name');

        $method->setTodo('return \'hello world\';');

        $method->setParams([
            new Param('name'),
            new Param('test', 'Test'),
        ]);

        $this->assertEquals($method->generate(), <<<M
    public function name(\$name, \Test \$test)
    {
        return 'hello world';
    }
M
        );
    }

    public function testGetSetter()
    {
        $getSetter = new GetSetter('name', 'string');

        $this->assertEquals($getSetter->generate(), <<<M
    /**
     * @return string
     */
    public function getName()
    {
        return \$this->name;
    }

    /**
     * @param string \$name
     * @return \$this
     */
    public function setName(\$name)
    {
        \$this->name = \$name;

        return \$this;
    }
M
);

        $getSetter = new GetSetter('age', 'int');

        $this->assertEquals($getSetter->generate(), <<<M
    /**
     * @return int
     */
    public function getAge()
    {
        return \$this->age;
    }

    /**
     * @param int \$age
     * @return \$this
     */
    public function setAge(\$age)
    {
        \$this->age = \$age;

        return \$this;
    }
M
        );
    }

    public function testObject()
    {
        $object = new Obj('Test', "Test");

        $object->setProperties([
            new Property('name', Property::PROPERTY_ACCESS_PROTECTED, 'string')
        ]);

        $object->setExtends(new Obj('FileInfo'));

        $object->setImplements([
            new Obj('Iterator'),
        ]);

        $object->setMethods([
            new GetSetter('name', 'string'),
            new Method('age', Method::METHOD_ACCESS_PROTECTED, Method::METHOD_STATIC),
        ]);

        $this->assertEquals($object->generate(), <<<M

namespace Test;

class Test extends \FileInfo implements \Iterator
{
    /**
     * @var string
     */
    protected \$name;

    /**
     * @return string
     */
    public function getName()
    {
        return \$this->name;
    }

    /**
     * @param string \$name
     * @return \$this
     */
    public function setName(\$name)
    {
        \$this->name = \$name;

        return \$this;
    }

    protected static function age()
    {
        // TODO...
    }
}
M
);
    }

    public function testParam()
    {
        $name = new Param('name');

        $this->assertEquals('$name', $name->generate());

        $name = new Param('name', 'Test');

        $this->assertEquals('\Test $name', $name->generate());

        $name = new Param('name', 'Test', null);

        $this->assertEquals('\Test $name = null', $name->generate());
    }
}

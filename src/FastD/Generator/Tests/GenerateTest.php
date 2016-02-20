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
use FastD\Generator\Factory\Object;
use FastD\Generator\Factory\Property;

class GenerateTest extends \PHPUnit_Framework_TestCase
{
    public function testProperty()
    {
        $name = new Property('name');

//        echo $name->generate();

        $name = new Property('name', Property::PROPERTY_ACCESS_PRIVATE);

//        echo $name->generate();

        $name = new Property('name', Property::PROPERTY_ACCESS_PROTECTED, 'string');

//        echo $name->generate();

        $name = new Property('name', Property::PROPERTY_CONST, 'string');

//        echo $name->generate();

        $name = new Property('name', Property::PROPERTY_ACCESS_PROTECTED, 'string');

        $name->setStatic();

//        echo $name->generate();
    }

    public function testMethod()
    {
        $method = new Method('name');

//        echo $method->generate();

        $method = new Method('name', Method::METHOD_ACCESS_PROTECTED);

//        echo $method->generate();

        $method = new Method('name', Method::METHOD_ACCESS_PRIVATE);

//        echo $method->generate();

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_STATIC);

//        echo $method->generate();

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_ABSTRACT);

//        echo $method->generate();

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_INTERFACE);

//        echo $method->generate();

        $method = new Method('name', Method::METHOD_ACCESS_PUBLIC, Method::METHOD_INTERFACE);

        $method->setParams([
            'name',
            new Object('test'),
            new Object('test2', 'Abc'),
        ]);

//        echo $method->generate();
    }

    public function testGetSetter()
    {
        $getSetter = new GetSetter('name', 'string');

//        echo $getSetter->generate();

        $getSetter = new GetSetter('age', 'int');

//        echo $getSetter->generate();
    }

    public function testObject()
    {
        $object = new Object('Test');

        $object->setProperties([
            new Property('name', Property::PROPERTY_ACCESS_PROTECTED, 'string')
        ]);

        $object->setExtends(new Object('FileInfo'));

        $object->setImplements([
            new Object('Iterator'),
        ]);

        $object->setMethods([
            new GetSetter('name', 'string'),
            new Method('age', Method::METHOD_ACCESS_PROTECTED, Method::METHOD_STATIC),
        ]);

//        echo $object->generate();
    }

    public function testObjectNamespace()
    {
        $object = new Object('Test', "Test");

//        echo $object->generate();
    }
}

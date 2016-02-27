<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/21
 * Time: 下午4:22
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

use FastD\Generator\Parser\ObjectParse;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('\\Test\\Test')) {
            include __DIR__ . '/Output/Test.php';
        }

        if (!class_exists('\\Test\\Test2')) {
            include __DIR__ . '/Output/Test2.php';
        }

        if (!class_exists('\\Test\\Test3')) {
            include __DIR__ . '/Output/Test3.php';
        }

        if (!class_exists('\\Test\\Test4')) {
            include __DIR__ . '/Output/Test4.php';
        }

        if (!class_exists('\\Test\\Test5')) {
            include __DIR__ . '/Output/TestInterface.php';
            include __DIR__ . '/Output/Test5.php';
        }
    }

    /**
     * $generator = new Generator();
     * $generator->save();
     */
    public function testObject()
    {
        $parser = new ObjectParse('\\Test\\Test2');

//        echo $parser->getContent();

        $parser = new ObjectParse('\\Test\\Test4');

//        echo $parser->getContent();

        $parser = new ObjectParse('\\Test\\Test5');

//        echo $parser->getContent();
    }

    public function testMethods()
    {
        $parser = new ObjectParse('\\Test\\Test2');

        $method = $parser->getMethod('test');

        $this->assertEquals($method->getContent(), <<<M
    public function test(FastD\Generator\Generator \$generator, \$name = 'test', \$test = self::TESET, \$four = 11)
    {}
M
);
    }

    public function testProperty()
    {
        $parser = new ObjectParse('\\Test\\Test2');

        $property = $parser->getProperty('default');

        $this->assertEquals($property->getName(), 'default');

        $this->assertEquals('jan', $property->getValue());

        $this->assertEquals('    protected $default = \'jan\';', $property->getContent());

        $property = $parser->getProperty('name');

        $this->assertEquals($property->getName(), 'name');

        $this->assertEquals(null, $property->getValue());

        $this->assertEquals('    protected $name;', $property->getContent());
    }

    public function testConstant()
    {
        $parser = new ObjectParse('\\Test\\Test2');

        $const = $parser->getConstant('TESET');

        $this->assertEquals('TESET', $const->getName());

        $this->assertEquals('abc', $const->getValue());
    }

    public function testParameters()
    {
        $parser = new ObjectParse('\\Test\\Test2');

        $method = $parser->getMethod('test');

        $parameter = $method->getParameter('generator');

        $this->assertEquals($parameter->getContent(), 'FastD\Generator\Generator $generator');

        $parameter = $method->getParameter('name');

        $this->assertEquals($parameter->getContent(), '$name = \'test\'');

        $parameter = $method->getParameter('four');

        $this->assertEquals($parameter->getContent(), '$four = 11');

        $parameter = $method->getParameter('test');

        $this->assertEquals($parameter->getContent(), '$test = self::TESET');

        $parser = new ObjectParse('\\Test\\Test3');

        $method = $parser->getMethod('test');

        $parameter = $method->getParameter('generator');

        $this->assertEquals($parameter->getContent(), 'FastD\Generator\Generator $generator = null');
    }

    public function testUsage()
    {
        $parser = new ObjectParse('\\Test\\Test5');

        $this->assertEquals(['FastD\Generator\Generator'], $parser->getUsages());
    }
}
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

use FastD\Generator\Factory\Method;
use FastD\Generator\Factory\Property;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $generator = new Generator(__DIR__ . '/Output/Test.php');

        $this->assertEquals('Test', $generator->getClassName());

        $this->assertEquals('', $generator->getNamespace());

        $this->assertEquals(__DIR__ . '/Output/Test.php', $generator->getFileName());
    }

    public function testProperty()
    {
        $generator = new Generator(__DIR__ . '/Output/Test.php');

        $generator->setProperty(new Property('name', 'string'));
        $generator->setMethod(new Method('test', 'string'));

        $generator->output();
    }
}

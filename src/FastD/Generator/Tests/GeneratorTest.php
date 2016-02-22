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

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $generator = new Generator('Test', "Test");

//        echo $generator->output();
    }

    public function testExtends()
    {
        $generator = new Generator('Test', "Test");

        $ext = new Object('Base', "Base");

        $generator->setExtends($ext);

//        echo $generator->output();
    }

    public function testImplements()
    {
        $generator = new Generator('Test', "Test");

        $ext = new Object('Base', "Base");

        $generator->setExtends($ext);

        $interface = new Object('BI', 'Bi');

        $generator->setImplements([$interface]);

//        echo $generator->output();
    }
}

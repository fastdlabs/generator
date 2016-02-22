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
    }

    public function testObject()
    {
        $parser = new ObjectParse('\\Test\\Test');

        echo $parser->getContent();
    }

    public function testObject2()
    {
        $parser = new ObjectParse('\\Test\\Test2');

        echo $parser->getContent();
    }
}
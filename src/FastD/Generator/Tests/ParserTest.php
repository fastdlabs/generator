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

    public function testMethods()
    {
        $parser = new ObjectParse('\\Test\\Test2');

        $this->assertEquals(<<<M

namespace Test;

use FastD\Generator\Generator;

class Test2 extends \Test\Test implements \Test\TestInterface
{
    /**
     * @const mixed
     */
    const TESET = 'abc';

    /**
     * @var mixed
     */
    protected \$name;

    /**
     * @var mixed
     */
    protected \$default = 'jan';

    /**
     * @var mixed
     */
    protected static \$age = 18;

    public function test(\FastD\Generator\Generator \$generator, \$name = 'test', \$test = 'self::TESET', \$four = 11)
    {
        // TODO...
    }
}
M
, $parser->getContent());
    }
}